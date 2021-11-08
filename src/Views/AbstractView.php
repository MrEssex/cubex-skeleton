<?php

namespace CubexBase\Application\Views;

use MrEssex\CubexFramework\AbstractBase;

abstract class AbstractView extends AbstractBase implements ViewClass
{
  public function getPageClass(): string
  {
    return $this->getBlockName();
  }

  public function shouldCache(): bool
  {
    return !$this->getContext()->isLocal();
  }
}