<?php

namespace CubexBase\Application\Routing;

use Cubex\Routing\RouteProcessor;
use CubexBase\Application\Pages\HomePage\HomeController;
use CubexBase\Application\Pages\NotFound\NotFoundController;

class Router extends RouteProcessor
{
  protected array $_routes = [
    '/$' => HomeController::class,
  ];

  protected function _generateRoutes()
  {
    foreach($this->_routes as $url => $endpoint)
    {
      yield self::_route($url, $endpoint);
    }

    return NotFoundController::class;
  }
}
