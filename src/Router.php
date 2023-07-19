<?php

namespace CubexBase\Application;

use CubexBase\Application\Api\ApiController;
use CubexBase\Application\Controllers\FrontendController;

class Router extends \Cubex\Routing\Router
{
  protected function _generateRoutes()
  {
    yield self::_route('/v1', ApiController::class);

    return FrontendController::class;
  }
}
