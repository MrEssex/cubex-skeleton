<?php

namespace CubexBase\Application\Views;

use CubexBase\Application\AbstractBase;

abstract class AbstractPage extends AbstractBase implements PageClass
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
