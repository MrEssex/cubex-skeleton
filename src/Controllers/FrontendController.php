<?php

namespace CubexBase\Application\Controllers;

use CubexBase\Application\Layout\LayoutController;
use CubexBase\Application\Views\Home\HomeViewModel;
use Packaged\Http\Response;

class FrontendController extends LayoutController
{
  protected function _generateRoutes()
  {
    yield self::_route('$', 'home');

    return 'error';
  }

  public function processHome()
  {
    return HomeViewModel::withContext($this);
  }

  public function processError(): Response
  {
    return Response::create('oops, not found', 404);
  }
}
