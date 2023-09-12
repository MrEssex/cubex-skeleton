<?php

namespace CubexBase\Application\Http\Controllers;

use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Http\Layout\LayoutController;
use CubexBase\Application\Http\Middleware\ExampleMiddleware;

class SecureController extends LayoutController
{
  protected function _middleware(): array
  {
    return [
      ExampleMiddleware::class,
    ];
  }

  protected function _generateRoutes()
  {
    yield self::_route('$', 'secure');
  }

  public function getSecure(AppContext $ctx)
  {
    return 'This should never be seen';
  }
}
