<?php

namespace CubexBase\Application\Http\Controllers;

use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Http\Forms\ExampleForm\ExampleForm;
use CubexBase\Application\Http\Layout\LayoutController;
use CubexBase\Application\Http\Views\Home\HomeView;

class HomeController extends LayoutController
{
  protected function _generateRoutes()
  {
    yield self::_route('$', 'home');
  }

  public function getHome(AppContext $ctx)
  {
    $form = ExampleForm::withContext($this, 'example_form');
    $form->hydrate($ctx->request()->request->all());
    $form->hydrate($ctx->request()->query->all());

    $seo = $ctx->seo();
    $seo->meta('description', 'This is the description');

    return HomeView::withContext($this)
      ->setForm($form);
  }

  public function postHome(AppContext $ctx)
  {
    return 'Hello World! Post';
  }

  // if isXMLHttpRequest then return json
  public function ajaxHome(AppContext $ctx)
  {
    return json_encode(['message' => 'Hello World! Ajax']);
  }

  public function putHome(AppContext $ctx)
  {
    return 'Hello World! Put';
  }
}
