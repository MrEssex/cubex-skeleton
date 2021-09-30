<?php
namespace CubexBase\Application\Application\Authentication;

use CubexBase\Application\Application\Authentication\Controllers\LoginController;
use CubexBase\Application\Routing\AbstractRouter;

class AuthenticationRouter extends AbstractRouter
{
  protected array $_routes = [
    'login' => LoginController::class,
  ];
}
