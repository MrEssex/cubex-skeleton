<?php

namespace CubexBase\Application\Controllers;

use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Layout\LayoutController;
use CubexBase\Application\Views\Home\HomeViewModel;
use Packaged\Http\Response;
use Packaged\Http\Responses\RedirectResponse;

class FrontendController extends LayoutController
{
  protected function _generateRoutes()
  {
    yield self::_route('$', 'home');
    yield self::_route('test', 'test');
    yield self::_route('login', 'login');
    yield self::_route('logout', 'logout');

    return 'error';
  }

  public function processHome(AppContext $ctx)
  {
    return HomeViewModel::withContext($this);
  }

  public function processTest(AppContext $ctx): RedirectResponse
  {
    $flashes = $ctx->getFlashBag();
    $flashes->add('success', 'This is a success message');

    return RedirectResponse::create('/');
  }

  public function processLogin(AppContext $ctx): RedirectResponse
  {
    $flashes = $ctx->getFlashBag();
    $flashes->add('success', 'You have been logged in');

    $user = 'test';
    $ctx->getSession()->set('user', $user);

    return RedirectResponse::create('/');
  }

  public function processLogout(AppContext $ctx): RedirectResponse
  {
    $ctx->getSession()->remove('user');
    $ctx->getSession()->invalidate();

    return RedirectResponse::create('/');
  }

  public function processError(): Response
  {
    return Response::create('oops, not found', 404);
  }
}
