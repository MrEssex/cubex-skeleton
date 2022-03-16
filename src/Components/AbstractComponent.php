<?php

namespace CubexBase\Application\Components;

use CubexBase\Application\AbstractBase;

abstract class AbstractComponent extends AbstractBase
{
  public function __construct()
  {
    parent::__construct();
    $this->addClass($this->_defaultClasses());
  }

  protected function _defaultClasses(): array
  {
    return [];
  }
}
