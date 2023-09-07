<?php

namespace CubexBase\Application\Controllers;

use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Layout\LayoutController;
use CubexBase\Application\Views\Home\HomeView;
use Packaged\Http\Response;
use Packaged\Http\Responses\RedirectResponse;

class FrontendController extends LayoutController
{
  protected function _generateRoutes()
  {
    yield self::_route('$', 'home');
    yield self::_route('test', 'test');

    return 'error';
  }

  public function processHome(AppContext $ctx)
  {
    return HomeView::withContext($this);
  }

  public function processTest(AppContext $ctx): RedirectResponse
  {
    $ctx->flash()->addMessage('success', 'This is a test message');
    return RedirectResponse::create('/');
  }

  public function processError(): Response
  {
    return Response::create('oops, not found', 404);
  }
}
