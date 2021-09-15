<?php

namespace CubexBase\Frontend\Routing;

use Cubex\Routing\RouteProcessor;
use CubexBase\Frontend\Pages\HomePage\HomeController;
use CubexBase\Frontend\Pages\NotFound\NotFoundController;

class Router extends RouteProcessor
{
  protected function _generateRoutes()
  {
    yield self::_route('/$', HomeController::class);

    return NotFoundController::class;
  }
}
