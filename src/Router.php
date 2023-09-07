<?php

namespace CubexBase\Application;

use CubexBase\Application\Api\ApiController;
use CubexBase\Application\Http\Controllers\FrontendController;

class Router extends \Cubex\Routing\Router
{
  protected function _generateRoutes()
  {
    yield self::_route('/api/v1', ApiController::class);

    return FrontendController::class;
  }
}
