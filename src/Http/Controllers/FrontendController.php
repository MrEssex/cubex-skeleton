<?php

namespace CubexBase\Application\Http\Controllers;

use CubexBase\Application\Context\Providers\FlashMessageProvider;
use CubexBase\Application\Context\Providers\SeoProvider;
use CubexBase\Application\Http\Forms\ExampleForm\ExampleForm;
use CubexBase\Application\Http\Layout\LayoutController;
use CubexBase\Application\Http\Views\Home\HomeView;
use Packaged\Http\Responses\RedirectResponse;

class FrontendController extends LayoutController
{
  protected function _generateRoutes()
  {
    yield self::_route('$', 'home');
    yield self::_route('test', 'test');
    yield self::_route('secure', SecureController::class);
  }

  public function getHome(SeoProvider $seo)
  {
    $form = ExampleForm::withContext($this, 'example_form');
    $form->hydrate($this->request()->request->all());
    $form->hydrate($this->request()->query->all());

    $seo->meta('description', 'This is the description');

    return HomeView::withContext($this)
      ->setForm($form);
  }

  public function getTest(FlashMessageProvider $flash)
  {
    $flash->addMessage('success', 'This is a test message');
    return RedirectResponse::create('/');
  }
}
