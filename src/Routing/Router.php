<?php


namespace FusionBase\Application\Routing;


use Cubex\Routing\RouteProcessor;
use FusionBase\Application\Pages\HomePage\HomeController;
use FusionBase\Application\Pages\NotFound\NotFoundController;
use Generator;
use Packaged\Routing\Handler\Handler;
use Packaged\Routing\Route;

/**
 * Class Router
 * @package FusionBase\Application\Routing
 */
class Router extends RouteProcessor
{

  /**
   * @param string $type
   * @param string|callable|Handler $result
   *
   * @return Route
   */
  protected static function _routeReq($type, $result)
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