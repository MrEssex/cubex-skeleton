<?php

namespace CubexBase\Application;

use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\Context\Context;
use Exception;
use Packaged\Context\Context as PackagedContext;
use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;
use Packaged\Ui\Html\TemplatedHtmlElement;
use PackagedUi\BemComponent\BemComponent;
use PackagedUi\BemComponent\BemComponentTrait;

abstract class AbstractBase extends TemplatedHtmlElement
  implements WithContext, ContextAware, BemComponent, Translatable
{
  use BemComponentTrait;
  use ContextAwareTrait;
  use WithContextTrait;
  use TranslatableTrait;
  use GetTranslatorTrait;

  /**
   * @throws Exception
   */
  public function getContext(): PackagedContext
  {
    if($this->_context instanceof Context)
    {
      return $this->_context;
    }

    throw new Exception('Invalid Context Passed through');
  }

  public function __construct()
  {
    $this->addClass($this->getBlockName());
  }
}