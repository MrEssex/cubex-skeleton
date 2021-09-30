<?php
namespace CubexBase\Application\Routing;

use Cubex\Routing\RouteProcessor;
use CubexBase\Application\Controllers\NotFoundController;

abstract class AbstractRouter extends RouteProcessor
{
  protected array $_routes = [];

  protected function _generateRoutes()
  {
    foreach($this->_routes as $url => $endpoint)
    {
      yield self::_route($url, $endpoint);
    }

    return NotFoundController::class;
  }
}
