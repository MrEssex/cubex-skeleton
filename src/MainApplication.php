<?php

namespace CubexBase\Application;

use Cubex\Application\Application;
use Cubex\Cubex;
use Cubex\Events\Handle\ResponsePreSendHeadersEvent;
use CubexBase\Application\Context\AppContext;
use Exception;
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
 * @method AppContext getContext()
 */
class MainApplication extends Application
{
  private const DISPATCH_PATH = '/_res';

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

    if(ValueAs::bool($this->getContext()->config()->getItem('serve', 'redirect_https')))
    {
      yield InsecureRequestUpgradeRoute::i();
    }

    $this->_setupApplication();

    return parent::_generateRoutes();
  }

  protected function _setupApplication(): void
  {
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

    $csp = new ContentSecurityPolicy();
    $csp->setDirective(ContentSecurityPolicy::IMG_SRC, '*');
    $response->headers->set($csp->getKey(), $csp->getValue());

    return $response;
  }

  protected function _defaultHandler(): Handler
  {
    return new Router();
  }
}
