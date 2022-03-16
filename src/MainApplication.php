<?php

namespace CubexBase\Application;

use Cubex\Application\Application;
use Cubex\Cubex;
use Cubex\Events\Handle\ResponsePreSendHeadersEvent;
use Cubex\Sitemap\SitemapListener;
use CubexBase\Application\Api\ApiController;
use Exception;
use MrEssex\FileCache\AbstractCache;
use MrEssex\FileCache\ApcuCache;
use Packaged\Context\Conditions\ExpectEnvironment;
use Packaged\Context\Context;
use Packaged\Dispatch\Dispatch;
use Packaged\Dispatch\Resources\ResourceFactory;
use Packaged\Helpers\Path;
use Packaged\Helpers\ValueAs;
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
 * @method \CubexBase\Application\Context\Context getContext(): context
 */
class MainApplication extends Application
{
  private const DISPATCH_PATH = '/_res';
  public static AbstractCache $_cache;

  public function __construct(Cubex $cubex)
  {
    parent::__construct($cubex);
    $cache = new ApcuCache();
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
    $context = $this->getContext();
    $dispatch = new Dispatch($context->getProjectRoot(), self::DISPATCH_PATH);

    $dispatch
      ->config()
      ->addItem(
        'optimisation',
        'webp',
        $context->config()->getItem('dispatch', 'opt-webp', true)
      );

    $dispatch
      ->config()
      ->addItem('ext.css', 'sourcemap', $context->config()->getItem('dispatch', 'opt-sourcemap', false));

    $dispatch
      ->config()
      ->addItem('ext.js', 'sourcemap', $context->config()->getItem('dispatch', 'opt-sourcemap', false));

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

    yield self::_route(
      '/favicon.ico',
      static function (Context $c) {
        return ResourceFactory::fromFile(Path::system($c->getProjectRoot(), 'public/favicon.ico'));
      }
    );

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
      "/robots.txt",
      static function (Context $c) {
        return TextResponse::create(file_get_contents(Path::system($c->getProjectRoot(), 'public/robots.txt')));
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
      }
    );

    if($ctx->matches(ExpectEnvironment::local()))
    {
      SitemapListener::with($this->getCubex(), $ctx);
    }
  }

  protected function _setupHeaders(ResponsePreSendHeadersEvent $event)
  {
    $response = $event->getResponse();

    if($response instanceof Response)
    {
      $context = $event->getContext();
      $allowed = [
        $context->request()->urlSprintf(),
        'https://fonts.googleapis.com',
      ];

      if(in_array($context->request()->headers->get('origin'), $allowed, true))
      {
        $response->headers->set('Access-Control-Allow-Origin', $context->request()->headers->get('origin'));
      }
    }

    return $response;
  }

  protected function _defaultHandler(): Handler
  {
    return new Router();
  }
}
