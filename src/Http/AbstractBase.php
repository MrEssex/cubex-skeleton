<?php

namespace CubexBase\Application\Http;

use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\Context\AppContext;
use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;
use Packaged\Ui\Html\TemplatedHtmlElement;
use PackagedUi\BemComponent\BemComponent;
use PackagedUi\BemComponent\BemComponentTrait;

/**
 * Class AbstractBase
 *
 * @package CubexBase\Application
 */
abstract class AbstractBase extends TemplatedHtmlElement
  implements WithContext, ContextAware, BemComponent, Translatable
{
  use BemComponentTrait;
  use ContextAwareTrait;
  use WithContextTrait;
  use TranslatableTrait;
  use GetTranslatorTrait
  {
    GetTranslatorTrait::_getTranslator insteadof TranslatableTrait;
  }

  public function __construct()
  {
    $this->addClass($this->getBlockName());
  }

  public function getContext(): AppContext
  {
    return $this->_context;
  }
}
