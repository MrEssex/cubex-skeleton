<?php

namespace CubexBase\Application\Http\Controllers;

use CubexBase\Application\Http\Layout\LayoutController;

class FrontendController extends LayoutController
{
  protected function _generateRoutes()
  {
    yield self::_route('$', HomeController::class);
    yield self::_route('test', TestController::class);
    yield self::_route('secure', SecureController::class);
  }
}
