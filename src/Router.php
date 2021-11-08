<?php

namespace CubexBase\Application;

use Cubex\Routing\RouteProcessor;
use CubexBase\Application\Views\HomeView\HomeController;
use CubexBase\Application\Views\NotFoundView\NotFoundController;

class Router extends RouteProcessor
{
  protected function _generateRoutes()
  {
    yield self::_route('/$', HomeController::class);

    return NotFoundController::class;
  }
}
