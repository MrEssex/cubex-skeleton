<?php

namespace CubexBase\Application\Pages;

use CubexBase\Application\AbstractBase;
use Packaged\Context\Conditions\ExpectEnvironment;

abstract class AbstractPage extends AbstractBase implements PageClass
{
  public function getPageClass(): string
  {
    return $this->getBlockName();
  }

  public function shouldCache(): bool
  {
    return !$this->getContext()->matches(ExpectEnvironment::local());
  }
}