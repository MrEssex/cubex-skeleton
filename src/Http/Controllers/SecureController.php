<?php

namespace CubexBase\Application\Http\Controllers;

use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Http\Layout\LayoutController;
use CubexBase\Application\Http\Middleware\ExampleMiddleware;
use Symfony\Component\HttpFoundation\Response;

class SecureController extends LayoutController
{
  protected function _middleware(): array
  {
    return [
      new ExampleMiddleware(),
    ];
  }

  protected function _generateRoutes()
  {
    yield self::_route('$', 'secure');
  }

  public function getSecure(AppContext $ctx)
  {
    return Response::create('This should never be seen');
  }
}
