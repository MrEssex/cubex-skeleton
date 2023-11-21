<?php

namespace CubexBase\Application;

use Cubex\Application\Application;
use Cubex\Cubex;
use Cubex\Events\Handle\ResponsePreSendHeadersEvent;
use Cubex\Sitemap\SitemapListener;
use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Context\Providers\FlashMessageProvider;
use MrEssex\FileCache\AbstractCache;
use MrEssex\FileCache\ApcuCache;
use Packaged\Context\Conditions\ExpectEnvironment;
use Packaged\Context\Context;
use Packaged\DiContainer\DependencyInjector;
use Packaged\Dispatch\Dispatch;
use Packaged\Dispatch\Resources\ResourceFactory;
use Packaged\Helpers\Path;
use Packaged\Helpers\ValueAs;
use Packaged\Http\Headers\ContentSecurityPolicy;
use Packaged\Http\Response;
use Packaged\Http\Responses\TextResponse;
use Packaged\Routing\Handler\Handler;
use Packaged\Routing\HealthCheckCondition;
use Packaged\Routing\Route;
use Packaged\Routing\Routes\InsecureRequestUpgradeRoute;
use Symfony\Component\HttpFoundation\Response as SResponse;

/**
 * @method AppContext getContext(): context
 */
class MainApplication extends Application
{
  public const DISPATCH_PATH = '/_res';
  public static AbstractCache $_cache;

  public function __construct(Cubex $cubex)
  {
    $cache = new ApcuCache(); //new FileCache();
    $cache->setTtl(30);
    self::$_cache = $cache;

    parent::__construct($cubex);
  }

  protected function _setupApplication(Cubex $cubex): void
  {
    $ctx = $this->getContext();

    $cubex->aliasAbstract(AppContext::class, Context::class);
    $ctx->prepareTranslator('/translations/', $ctx->matches(ExpectEnvironment::local()));

    $cubex->listen(
      ResponsePreSendHeadersEvent::class,
      function (ResponsePreSendHeadersEvent $event) {
        $this->_setupHeaders($event);
        $this->_setupCookies($event);
      }
    );

    // Dont generate sitemap on api requests
    if($ctx->matches(ExpectEnvironment::local()) && !str_starts_with($ctx->request()->path(), '/api'))
    {
      SitemapListener::with($cubex, $ctx);
    }
  }

  protected function _criticalSetup(Cubex $cubex)
  {
    // Bindings that are required to execute for some basic routes, e.g. static resources
    $cubex->share(
      Dispatch::class,
      Dispatcher::create($cubex->getContext(), static::DISPATCH_PATH),
      DependencyInjector::MODE_IMMUTABLE
    );
  }

  protected function _setupHeaders(ResponsePreSendHeadersEvent $event): SResponse
  {
    $response = $event->getResponse();
    /** @var AppContext $ctx */
    $ctx = $event->getContext();

    $allowed = [
      $ctx->request()->urlSprintf(), // Self
      'https://fonts.googleapis.com', // Google Fonts
    ];

    if(in_array($ctx->request()->headers->get('origin'), $allowed, true))
    {
      $response->headers->set('Access-Control-Allow-Origin', $ctx->request()->headers->get('origin'));
    }

    $currentUrl = $ctx->request()->urlSprintf();
    $schema = $ctx->request()->getScheme();
    if(!str_contains($currentUrl, $schema . '://www'))
    {
      $currentUrl = str_replace($schema . '://', $schema . '://www.', $currentUrl);
    }

    $csp = new ContentSecurityPolicy([
      ContentSecurityPolicy::DEFAULT_SRC => ["'self'", $currentUrl],
      ContentSecurityPolicy::IMG_SRC => ["'self'", $currentUrl],
      ContentSecurityPolicy::SCRIPT_SRC => ["'self'", "'unsafe-inline'", "'unsafe-eval'", $currentUrl],
      ContentSecurityPolicy::OBJECT_SRC => ["'none'"],
      ContentSecurityPolicy::FRAME_ANCESTORS => ["'none'"],
    ]);
    $response->headers->set($csp->getKey(), $csp->getValue());

    return $response;
  }

  protected function _setupCookies(ResponsePreSendHeadersEvent $event)
  {
    $response = $event->getResponse();
    $cubex = @$this->getCubex();

    // Add flash messages to cookies
    $flash = $cubex->retrieve(FlashMessageProvider::class);
    $flash->hasMessages() ?
      $response->headers->setCookie($flash->toCookie()) :
      $response->headers->clearCookie('flash');
  }

  protected function _generateRoutes()
  {
    yield Route::with(new HealthCheckCondition())->setHandler(
      static function () {
        return SResponse::create('OK');
      }
    );

    $resourceRoutes = ['favicon.ico', 'icon.png', 'icon.svg', 'tile.png', 'tile-wide.png', 'icon-512x512.png'];
    foreach($resourceRoutes as $route)
    {
      yield self::_route(
        '/' . $route,
        static function (Context $c) use ($route) {
          return ResourceFactory::fromFile(Path::system($c->getProjectRoot(), 'public/' . $route));
        }
      );
    }

    $textRoutes = ['robots.txt', 'site.webmanifest', 'humans.txt'];
    foreach($textRoutes as $route)
    {
      yield self::_route(
        '/' . $route,
        static function (Context $c) use ($route) {
          return TextResponse::create(file_get_contents(Path::system($c->getProjectRoot(), 'public/' . $route)));
        }
      );
    }

    yield self::_route(
      "/sitemap.xml",
      static function (Context $c) {
        return Response::create(
          file_get_contents(Path::system($c->getProjectRoot(), 'public/sitemap.xml')),
          200,
          ['content-type' => 'text/xml']
        );
      }
    );

    $cubex = @$this->getCubex();
    yield self::_route(static::DISPATCH_PATH, $cubex->resolve(Dispatcher::class));

    if(ValueAs::bool($this->getContext()->config()->getItem('serve', 'redirect_https')))
    {
      yield InsecureRequestUpgradeRoute::i();
    }

    $this->_setupApplication($cubex);

    return parent::_generateRoutes();
  }

  protected function _defaultHandler(): Handler
  {
    return new Router();
  }

  public function handle(Context $c): SResponse
  {
    $cubex = @$this->getCubex();
    $this->_criticalSetup($cubex);

    $path = $c->request()->getRequestUri();
    $language = $c->request()->getPreferredLanguage();

    if(self::$_cache->has($path . $language))
    {
      return $this->_prepareResponse($c, new Response(self::$_cache->get($path . $language)));
    }

    return parent::handle($c);
  }
}
