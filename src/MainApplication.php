<?php

namespace CubexBase\Application;

use Cubex\Application\Application;
use Cubex\Cubex;
use Cubex\Events\Handle\ResponsePreSendHeadersEvent;
use Cubex\Sitemap\SitemapListener;
use CubexBase\Application\Api\ApiController;
use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Context\FlashHeaders;
use Exception;
use MrEssex\FileCache\AbstractCache;
use MrEssex\FileCache\ApcuCache;
use Packaged\Context\Conditions\ExpectEnvironment;
use Packaged\Context\Context;
use Packaged\Dispatch\Dispatch;
use Packaged\Dispatch\Resources\ResourceFactory;
use Packaged\Helpers\Path;
use Packaged\Helpers\ValueAs;
use Packaged\Http\Headers\ContentSecurityPolicy;
use Packaged\Http\Response;
use Packaged\Http\Responses\TextResponse;
use Packaged\Routing\Handler\FuncHandler;
use Packaged\Routing\Handler\Handler;
use Packaged\Routing\HealthCheckCondition;
use Packaged\Routing\Route;
use Packaged\Routing\Routes\InsecureRequestUpgradeRoute;
use Symfony\Component\HttpFoundation\Response as SResponse;
use function in_array;

/**
 * @method AppContext getContext(): context
 */
class MainApplication extends Application
{
  private const DISPATCH_PATH = '/_res';
  public static AbstractCache $_cache;

  public function __construct(Cubex $cubex)
  {
    parent::__construct($cubex);
    $cache = new ApcuCache(); //new FileCache();
    $cache->setTtl(30);
    self::$_cache = $cache;
  }

  public function handle(Context $c): SResponse
  {
    $path = $c->request()->getRequestUri();
    $language = $c->request()->getPreferredLanguage();

    if(self::$_cache->has($path . $language))
    {
      return $this->_prepareResponse($c, new Response(self::$_cache->get($path . $language)));
    }

    return parent::handle($c);
  }

  /**
   * @throws Exception
   */
  protected function _initialize(): void
  {
    parent::_initialize();
    $this->_initDispatch();
  }

  /**
   * @throws Exception
   */
  protected function _initDispatch(): void
  {
    $ctx = $this->getContext();
    $config = $ctx->config();
    $dispatch = new Dispatch($ctx->getProjectRoot(), self::DISPATCH_PATH);

    $dispatch
      ->config()
      ->addItem('optimisation', 'webp', $config->getItem('dispatch', 'opt-webp', true));

    $dispatch
      ->config()
      ->addItem('ext.css', 'sourcemap', $config->getItem('dispatch', 'opt-sourcemap', false));

    $dispatch
      ->config()
      ->addItem('ext.js', 'sourcemap', $config->getItem('dispatch', 'opt-sourcemap', false));

    Dispatch::bind($dispatch);
  }

  /**
   * @throws Exception
   */
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

    yield self::_route(
      self::DISPATCH_PATH,
      new FuncHandler(
        static function (Context $c): SResponse {
          return Dispatch::instance()->handleRequest($c->request());
        }
      )
    );

    yield self::_route('/v1', ApiController::class);

    if(ValueAs::bool($this->getContext()->config()->getItem('serve', 'redirect_https')))
    {
      yield InsecureRequestUpgradeRoute::i();
    }

    $this->_setupApplication();

    return parent::_generateRoutes();
  }

  protected function _setupApplication(): void
  {
    $ctx = $this->getContext();
    $ctx->prepareTranslator('/translations/', $ctx->matches(ExpectEnvironment::local()));

    if(!$this->getCubex() instanceof Cubex)
    {
      return;
    }

    $this->getCubex()->listen(
      ResponsePreSendHeadersEvent::class,
      function (ResponsePreSendHeadersEvent $event) {
        $this->_setupHeaders($event);
        $this->_setupCookies($event);
      }
    );

    if($ctx->matches(ExpectEnvironment::local()))
    {
      SitemapListener::with($this->getCubex(), $ctx);
    }
  }

  protected function _setupHeaders(ResponsePreSendHeadersEvent $event): SResponse
  {
    $response = $event->getResponse();
    /** @var AppContext $ctx */
    $ctx = $event->getContext();

    $allowed = [
      $ctx->request()->urlSprintf(),
      'https://fonts.googleapis.com',
    ];

    if(in_array($ctx->request()->headers->get('origin'), $allowed, true))
    {
      $response->headers->set('Access-Control-Allow-Origin', $ctx->request()->headers->get('origin'));
    }

    if($context->request()->query->has('raw') && $context->matches(ExpectEnvironment::local()))
    {
      $response->headers->set('Content-Type', 'application/json');
    }

    $csp = new ContentSecurityPolicy();
    $csp->setDirective(ContentSecurityPolicy::IMG_SRC, '*');
    $response->headers->set($csp->getKey(), $csp->getValue());

    return $response;
  }

  protected function _defaultHandler(): Handler
  {
    return new Router();
  }

  protected function _setupCookies(ResponsePreSendHeadersEvent $event)
  {
    $response = $event->getResponse();
    /** @var AppContext $ctx */
    $ctx = $event->getContext();

    // Add flash messages to cookies
    $flash = $ctx->flash();
    if($flash->hasMessages())
    {
      $response->headers->setCookie(
        $flash->toCookie()
      );
    }
    else
    {
      $response->headers->clearCookie('flash');
    }
  }
}
