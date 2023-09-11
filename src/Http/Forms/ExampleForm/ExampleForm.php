<?php

namespace CubexBase\Application\Http\Forms\ExampleForm;

use CubexBase\Application\Http\Forms\AbstractForm;
use Packaged\Form\DataHandlers\TextDataHandler;

class ExampleForm extends AbstractForm
{
  public TextDataHandler $name;

  protected function _initDataHandlers()
  {
    parent::_initDataHandlers();
    $this->name = TextDataHandler::i();
  }

  protected function _configureDataHandlers()
  {
    parent::_configureDataHandlers();
    $this->name->setLabel('Insert Name');
  }

  public function getSubmitValue(): string
  {
    return 'Submit Me';
  }
}
