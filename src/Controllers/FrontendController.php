<?php

namespace CubexBase\Application\Controllers;

use CubexBase\Application\Api\Modules\Example\Procedures\ListExample;
use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Layout\LayoutController;
use CubexBase\Application\Views\Home\HomeViewModel;
use CubexBase\Transport\Modules\Example\Payloads\ListExamplePayload;
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
    $examples = ListExample::withContext($this)->execute(ListExamplePayload::i());

    $model = HomeViewModel::withContext($this);
    $model->examples = $examples;
    return $model;
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
