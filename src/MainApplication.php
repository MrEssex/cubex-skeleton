<?php

namespace FusionBase\Application;

use Cubex\Application\Application;
use Cubex\Events\Handle\ResponsePreSendHeadersEvent;
use Exception;
use FusionBase\Application\Routing\Router;
use Generator;
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

use function basename;
use function glob;
use function in_array;

/**
 * Class MainApplication
 * @package FusionBase\Application
 */
class MainApplication extends Application
{

  /** @var string */
  const DISPATCH_PATH = '/resources';

  /**
   * Initialize the Application
   * @throws Exception
   */
  protected function _initialize()
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

    Dispatch::bind($dispatch);
  }

  /**
   * @return callable|Generator|Handler|Route[]|string
   * @throws Exception
   */
  protected function _generateRoutes()
  {
    yield Route::with(new HealthCheckCondition())->setHandler(
      function () {
        return SResponse::create('OK');
      }
    );

    foreach (glob(Path::system($this->getContext()->getProjectRoot(), 'resources/favicon/*')) as $path) {
      yield self::_route(
        '/' . basename($path),
        function () use ($path) {
          return ResourceFactory::fromFile($path);
        }
      );
    }

    yield self::_route(
      "/robots.txt",
      function (Context $c) {
        return ResourceFactory::fromFile(Path::system($c->getProjectRoot(), 'public/robots.txt'));
      }
    );

    yield self::_route(
      self::DISPATCH_PATH,
      new FuncHandler(
        function (Context $c): SResponse {
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
  protected function _setupApplication()
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

          if (in_array($context->request()->headers->get('origin'), $allowed)) {
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