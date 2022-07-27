<?php

namespace CubexBase\Application;

use Cubex\Routing\RouteProcessor;
use CubexBase\Application\Api\ApiController;
use CubexBase\Application\Pages\HomePage\HomeController;
use CubexBase\Application\Pages\NotFoundPage\NotFoundController;

class Router extends RouteProcessor
{
  protected function _generateRoutes()
  {
    yield self::_route('api', ApiController::class);
    yield self::_route('/$', HomeController::class);

    return NotFoundController::class;
  }
}
