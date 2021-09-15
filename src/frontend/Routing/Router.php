<?php

namespace CubexBase\Frontend\Routing;

use Cubex\Routing\RouteProcessor;
use CubexBase\Frontend\Pages\HomePage\HomeController;
use CubexBase\Frontend\Pages\NotFound\NotFoundController;
use Generator;
use Packaged\Routing\Handler\Handler;
use Packaged\Routing\Route;

/**
 * Class Router
 *
 * @package CubexBase\Frontend\Routing
 */
class Router extends RouteProcessor
{

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
