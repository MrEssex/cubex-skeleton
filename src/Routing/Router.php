<?php

namespace CubexBase\Application\Routing;

use CubexBase\Application\Controllers\HomeController;

class Router extends AbstractRouter
{
  protected array $_routes = [
    '/$' => HomeController::class,
  ];
}
