<?php

namespace CubexBase\Application\Routing;

use Cubex\Routing\RouteProcessor;
use CubexBase\Application\Applications\Api\ApiController;
use CubexBase\Application\Pages\HomePage\HomeController;
use CubexBase\Application\Pages\NotFound\NotFoundController;
use Generator;
use Packaged\Routing\Handler\Handler;
use Packaged\Routing\Route;

/**
 * Class Router
 *
 * @package CubexBase\Application\Routing
 */
class Router extends RouteProcessor
{

  /**
   * @return Generator|string
   */
  protected function _generateRoutes()
  {
    yield self::_route('/$', HomeController::class);
    yield self::_route('/api', ApiController::class);

    return NotFoundController::class;
  }

  /**
   * @param string                  $type
   * @param string|callable|Handler $result
   *
   * @return Route
   */
  protected static function _routeReq(string $type, $result): Route
  {
    return Route::with(CachedFileRouter::i()->dir($type))->setHandler($result);
  }

}
