<?php

namespace CubexBase\Application\Http\Controllers;

use Cubex\Middleware\MiddlewareHandler;
use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Http\Layout\LayoutController;
use CubexBase\Application\Http\Middleware\ExampleMiddleware;
use Packaged\Context\Context;
use Packaged\Routing\Handler\FuncHandler;
use Symfony\Component\HttpFoundation\Response;

class SecureController extends LayoutController
{
  protected function _generateRoutes()
  {
    yield self::_route('$', 'secure');
  }

  public function getSecure(AppContext $ctx)
  {
    return Response::create('This should never be seen');
  }

  public function handle(Context $c): Response
  {
    $middleware = new MiddlewareHandler(new FuncHandler(fn(Context $c) => parent::handle($c)));
    $middleware->add(new ExampleMiddleware());
    return $middleware->handle($c);
  }
}
