<?php

namespace CubexBase\Application\Applications\Authentication\Forms;

use CubexBase\Application\Forms\AbstractForm;
use Packaged\Form\DataHandlers\EmailDataHandler;
use Packaged\Form\DataHandlers\SecureTextDataHandler;

/**
 * Class LoginForm
 * @package CubexBase\Application\Applications\Authentication\Forms
 */
class LoginForm extends AbstractForm
{
  /** @var EmailDataHandler */
  public EmailDataHandler $email;
  /** @var SecureTextDataHandler */
  public SecureTextDataHandler $password;

  /**
   * Initialise the data handlers
   */
  protected function _initDataHandlers(): void
  {
    parent::_initDataHandlers();
    $this->email = EmailDataHandler::i();
    $this->password = SecureTextDataHandler::i();
  }
}
