<?php

namespace CubexBase\Application;

use Cubex\Routing\RouteProcessor;
use CubexBase\Application\Http\Home\HomeController;
use CubexBase\Application\Http\NotFoundPage\NotFoundController;

class Router extends RouteProcessor
{
  protected function _generateRoutes()
  {
    yield self::_route('/$', HomeController::class);

    return NotFoundController::class;
  }
}
