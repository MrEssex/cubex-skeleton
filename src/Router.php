<?php

namespace CubexBase\Application;

use CubexBase\Application\Controllers\FrontendController;

class Router extends \Cubex\Routing\Router
{
  protected function _generateRoutes()
  {
    return FrontendController::class;
  }
}
