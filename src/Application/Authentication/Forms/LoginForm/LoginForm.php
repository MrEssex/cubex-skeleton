<?php
namespace CubexBase\Application\Application\Authentication\Forms\LoginForm;

use Packaged\Form\DataHandlers\TextDataHandler;
use Packaged\Form\Form\Form;

class LoginForm extends Form
{
  public TextDataHandler $username;

  protected function _initDataHandlers()
  {
    $this->username = TextDataHandler::i();
  }
}
