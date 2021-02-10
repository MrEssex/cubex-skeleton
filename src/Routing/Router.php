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
   * @return callable|Generator|Handler|Route[]|string|void
   */
  protected function _generateRoutes()
  {
    //Homepage
    yield self::_route('/$', HomeController::class);

    return NotFoundController::class;
  }

}
