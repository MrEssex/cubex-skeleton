<?php

namespace CubexBase\Application;

use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\Context\Context;
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
 * @package CubexBase\Application
 *
 * @method Context getContext(): Context
 */
abstract class AbstractBase extends TemplatedHtmlElement
  implements WithContext, ContextAware, BemComponent, Translatable
{
  use BemComponentTrait;
  use ContextAwareTrait;
  use WithContextTrait;
  use TranslatableTrait;
  use GetTranslatorTrait;

  /**
   * AbstractBase constructor.
   */
  public function __construct()
  {
    $this->addClass($this->getBlockName());
  }
}
