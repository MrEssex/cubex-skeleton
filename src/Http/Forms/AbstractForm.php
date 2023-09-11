<?php

namespace CubexBase\Application\Http\Forms;

use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\Http\Forms\Decorators\DefaultSubmitDecorator;
use CubexBase\Application\Http\Forms\Decorators\FormDecorator;
use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\Form\Csrf\CsrfForm;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;

abstract class AbstractForm extends CsrfForm implements ContextAware, Translatable, WithContext
{
  use ContextAwareTrait;
  use TranslatableTrait;
  use GetTranslatorTrait;
  use WithContextTrait;

  protected string $_submitValue = "Submit";

  protected function _defaultSubmitDecorator(): DefaultSubmitDecorator
  {
    $dec = DefaultSubmitDecorator::withContext($this);
    $dec->setValue($this->getSubmitValue());
    $dec->setInput($this->_defaultSubmitDecoratorInput());
    return $dec;
  }

  protected function _defaultDecorator(): FormDecorator
  {
    return FormDecorator::withContext($this);
  }

  protected function _defaultSubmitDecoratorInput()
  {
    return null;
  }

  public function getSubmitValue(): string
  {
    return $this->_submitValue;
  }
}

