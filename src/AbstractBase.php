<?php


namespace CubexBase\Application;

use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\Ui\Html\TemplatedHtmlElement;
use PackagedUi\BemComponent\BemComponent;
use PackagedUi\BemComponent\BemComponentTrait;

/**
 * Class AbstractBase
 * @package CubexBase\Application
 */
abstract class AbstractBase extends TemplatedHtmlElement implements WithContext, ContextAware, BemComponent
{
  use BemComponentTrait;
  use ContextAwareTrait;
  use WithContextTrait;

  /**
   * AbstractBase constructor.
   */
  public function __construct()
  {
    $this->addClass($this->getBlockName());
  }
}