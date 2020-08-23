<?php


namespace CubexBase\Application\Routing;


use Cubex\Routing\RouteProcessor;
use CubexBase\Application\Pages\HomePage\HomeController;
use CubexBase\Application\Pages\NotFound\NotFoundController;
use Generator;
use Packaged\Routing\Handler\Handler;
use Packaged\Routing\Route;

/**
 * Class Router
 * @package CubexBase\Application\Routing
 */
class Router extends RouteProcessor
{

  /**
   * @param string $type
   * @param string|callable|Handler $result
   *
   * @return Route
   */
  protected static function _routeReq($type, $result): Route
  {
    return Route::with(CachedFileRouter::i()->dir($type))->setHandler($result);
  }

  /**
   * @return callable|Generator|Handler|Route[]|string|void
   */
  protected function _generateRoutes()
  {
    //Homepage
    yield self::_route('/$', HomeController::class);

    return NotFoundController::class;
  }
}