<?php

namespace CubexBase\Application\Applications\Authentication\Controller;

use CubexBase\Application\Applications\Authentication\Forms\LoginForm;
use CubexBase\Application\Applications\Authentication\Pages\LoginPage\LoginPage;
use CubexBase\Application\Layout\LayoutController;
use CubexBase\Application\Pages\HomePage\Ui\HomePage;
use Generator;
use Packaged\Routing\Handler\Handler;
use Packaged\Routing\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class AuthController
 * @package CubexBase\Application\Applications\Authentication\Controller
 */
class AuthController extends LayoutController
{
  /**
   * @return callable|Generator|Handler|Route[]|string
   */
  protected function _generateRoutes()
  {
    yield self::_route('login', 'login');
    return parent::_generateRoutes();
  }

  /**
   * @return LoginPage
   */
  protected function getLogin(): LoginPage
  {
    $form = LoginForm::withContext($this, $this->getContext()->getSessionSecret());
    return LoginPage::withContext($this)->setLoginForm($form);
  }

  /**
   * @return LoginPage|RedirectResponse
   */
  protected function postLogin()
  {
    $form = LoginForm::withContext($this, $this->getContext()->getSessionSecret());
    $form->hydrate($this->getContext()->request()->query->all());
    $form->hydrate($this->getContext()->request()->request->all());

    $form->validate();

    if(!$form->isValid())
    {
      return LoginPage::withContext($this)->setLoginForm($form);
    }

    return HomePage::withContext($this);
  }

}
