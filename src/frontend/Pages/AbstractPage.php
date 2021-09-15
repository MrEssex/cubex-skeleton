<?php

namespace CubexBase\Frontend\Pages;

use CubexBase\Frontend\AbstractBase;

abstract class AbstractPage extends AbstractBase implements PageClass
{
  public function getPageClass(): string
  {
    return $this->getBlockName();
  }

  public function shouldCache(): bool
  {
    return false;
  }
}