<?php

namespace CubexBase\Application;

use CubexBase\Application\Context\Context;
use Exception;
use MrEssex\CubexFramework\AbstractBase as AbstractBaseAlias;
use Packaged\Context\Context as PackagedContext;

abstract class AbstractBase extends AbstractBaseAlias
{
  /**
   * @throws Exception
   */
  public function getContext(): PackagedContext
  {
    if(parent::getContext() instanceof Context)
    {
      return parent::getContext();
    }

    throw new Exception('Invalid Context Passed through');
  }
}
