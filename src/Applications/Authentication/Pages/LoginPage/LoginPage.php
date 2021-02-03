<?php

namespace CubexBase\Application\Applications\Authentication\Pages\LoginPage;

use CubexBase\Application\Applications\Authentication\Forms\LoginForm;
use CubexBase\Application\Pages\AbstractPage;
use Packaged\Glimpse\Core\AbstractContainerTag;
use Packaged\Glimpse\Tags\Div;
use Packaged\SafeHtml\SafeHtml;
use Throwable;

/**
 * Class LoginPage
 * @package CubexBase\Application\Applications\Authentication\Pages\LoginPage
 */
class LoginPage extends AbstractPage
{

  /** @var LoginForm */
  protected LoginForm $_loginForm;

  /**
   * @return string
   */
  public function getBlockName(): string
  {
    return 'login-page';
  }

  /**
   * @param LoginForm $loginForm
   *
   * @return LoginPage
   */
  public function setLoginForm(LoginForm $loginForm): LoginPage
  {
    $this->_loginForm = $loginForm;
    return $this;
  }

  /**
   * @return AbstractContainerTag|Div|SafeHtml|null
   * @throws Throwable
   */
  protected function _getContentForRender()
  {
    return Div::create(
      $this->_loginForm
    )->setId('login-form');
  }
}
