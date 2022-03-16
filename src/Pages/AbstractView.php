<?php

namespace CubexBase\Application\Pages;

use Cubex\Mv\Model;
use CubexBase\Application\AbstractBase;
use Packaged\Context\Conditions\ExpectEnvironment;

abstract class AbstractView extends AbstractBase implements ViewClass
{
  protected ?Model $_model;

  public function __construct(?Model $data = null)
  {
    $this->_model = $data;
    parent::__construct();
  }

  public function getPageClass(): string
  {
    return $this->getBlockName();
  }

  public function shouldCache(): bool
  {
    return !$this->getContext()->matches(ExpectEnvironment::local());
  }

  public function getModel(): ?Model
  {
    return $this->_model;
  }
}
