<?php

namespace CubexBase\Application\Routing;

use CubexBase\Application\Application\Authentication\AuthenticationRouter;
use CubexBase\Application\Controllers\HomeController;

class Router extends AbstractRouter
{
  protected array $_routes = [
    '/$'    => HomeController::class,
    '/auth' => AuthenticationRouter::class,
  ];
}
