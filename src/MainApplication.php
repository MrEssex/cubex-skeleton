<?php

namespace CubexBase\Application;

use Cubex\Application\Application;
use Cubex\Cubex;
use Cubex\Events\Handle\ResponsePreSendHeadersEvent;
use CubexBase\Application\Routing\Router;
use Exception;
use Generator;
use MrEssex\FileCache\FileCache;
use Packaged\Context\Context;
use Packaged\Dispatch\Dispatch;
use Packaged\Dispatch\Resources\ResourceFactory;
use Packaged\Helpers\Path;
use Packaged\Helpers\ValueAs;
use Packaged\Http\Response;
use Packaged\Routing\Handler\FuncHandler;
use Packaged\Routing\Handler\Handler;
use Packaged\Routing\HealthCheckCondition;
use Packaged\Routing\Route;
use Packaged\Routing\Routes\InsecureRequestUpgradeRoute;
use Symfony\Component\HttpFoundation\Response as SResponse;
use Throwable;

use function basename;
use function glob;
use function in_array;

/**
 * Class MainApplication
 * @package CubexBase\Application
 */
class MainApplication extends Application
{

  /** @var string */
  private const DISPATCH_PATH = '/resources';

  /** @var FileCache */
  public static FileCache $_cache;

  public function __construct(Cubex $cubex)
  {
    parent::__construct($cubex);
    self::$_cache = new FileCache(null, 30);
  }

  /**
   * @param Context $c
   *
   * @return SResponse
   * @throws Throwable
   */
  public function handle(Context $c): SResponse
  {
    $path = $c->request()->getRequestUri();
    $language = $c->request()->getPreferredLanguage();

    if (self::$_cache->has($path . $language)) {
      return $this->_prepareResponse($c, new Response(self::$_cache->get($path . $language)));
    }

    return parent::handle($c);
  }

  /**
   * Initialize the Application
   * @throws Exception
   */
  protected function _initialize(): void
  {
    parent::_initialize();

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
      ->addItem('ext.css', 'sourcemap', $context->config()->getItem('dispatch', 'opt_sourcemap', false));

    $dispatch
      ->config()
      ->addItem('ext.js', 'sourcemap', $context->config()->getItem('dispatch', 'opt_sourcemap', false));

    Dispatch::bind($dispatch);
  }

  /**
   * @return callable|Generator|Handler|Route[]|string
   * @throws Exception
   */
  protected function _generateRoutes()
  {
    yield Route::with(new HealthCheckCondition())->setHandler(
      static function () {
        return SResponse::create('OK');
      }
    );

    foreach (glob(Path::system($this->getContext()->getProjectRoot(), 'resources/favicon/*')) as $path) {
      yield self::_route(
        '/' . basename($path),
        static function () use ($path) {
          return ResourceFactory::fromFile($path);
        }
      );
    }

    yield self::_route(
      "/robots.txt",
      static function (Context $c) {
        return ResourceFactory::fromFile(Path::system($c->getProjectRoot(), 'public/robots.txt'));
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

    if (ValueAs::bool($this->getContext()->config()->getItem('serve', 'redirect_https'))) {
      yield InsecureRequestUpgradeRoute::i();
    }

    $this->_setupApplication();

    return parent::_generateRoutes();
  }

  /**
   * Setup the Application
   */
  protected function _setupApplication(): void
  {
    $this->getCubex()->listen(
      ResponsePreSendHeadersEvent::class,
      static function (ResponsePreSendHeadersEvent $event) {
        $response = $event->getResponse();

        if ($response instanceof Response) {
          $context = $event->getContext();
          $allowed = [
            $context->request()->urlSprintf(),
            'https://fonts.googleapis.com',
          ];

          if (in_array($context->request()->headers->get('origin'), $allowed, true)) {
            $response->headers->set('Access-Control-Allow-Origin', $context->request()->headers->get('origin'));
          }
        }
      }
    );
  }

  /**
   * @return Handler
   */
  protected function _defaultHandler(): Handler
  {
    return new Router();
  }

}