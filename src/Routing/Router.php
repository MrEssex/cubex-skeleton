<?php

namespace CubexBase\Application\Routing;

use Cubex\Routing\RouteProcessor;
use CubexBase\Application\Pages\HomePage\HomeController;
use CubexBase\Application\Pages\NotFound\NotFoundController;

class Router extends RouteProcessor
{
  protected function _generateRoutes()
  {
    yield self::_route('/$', HomeController::class);

    return NotFoundController::class;
  }
}
