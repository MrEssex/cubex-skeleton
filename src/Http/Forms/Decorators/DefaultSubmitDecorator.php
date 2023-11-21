<?php

namespace CubexBase\Application\Http\Forms\Decorators;

use Cubex\I18n\GetTranslatorTrait;
use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\Form\Decorators\FormSubmitDecorator;
use Packaged\Glimpse\Tags\Button;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;

class DefaultSubmitDecorator extends FormSubmitDecorator implements ContextAware, Translatable, WithContext
{
  use WithContextTrait;
  use ContextAwareTrait;
  use TranslatableTrait;
  use GetTranslatorTrait
  {
    GetTranslatorTrait::_getTranslator insteadof TranslatableTrait;
  }

  protected mixed $_input;

  public function setInput(mixed $input): DefaultSubmitDecorator
  {
    $this->_input = $input;
    return $this;
  }

  protected function _input()
  {
    if($this->_input === null)
    {
      $input = Button::create($this->_getValue());
      $input->addClass('btn--processing btn btn--success');
      $input->setAttribute('data-processing-text', 'processing');
      $this->_input = $input;
    }
    return $this->_input;
  }
}
