<?php

namespace CubexBase\Application\Http\Controllers;

use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Http\Layout\LayoutController;
use Packaged\Http\Responses\RedirectResponse;

class TestController extends LayoutController
{
  protected function _generateRoutes()
  {
    yield self::_route('$', 'test');
  }

  public function getTest(AppContext $ctx)
  {
    $ctx->flash()->addMessage('success', 'This is a test message');
    return RedirectResponse::create('/');
  }
}
