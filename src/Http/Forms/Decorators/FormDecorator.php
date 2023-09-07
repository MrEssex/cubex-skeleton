<?php

namespace CubexBase\Application\Http\Forms\Decorators;

use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\Form\Decorators\DefaultFormDecorator;

class FormDecorator extends DefaultFormDecorator implements ContextAware, WithContext
{
  use WithContextTrait;
  use ContextAwareTrait;

  protected function _getTemplatedPhtmlClassList(): array
  {
    return [get_class($this->getForm()), $this->_getTemplatedPhtmlClass(), DefaultFormDecorator::class];
  }
}
