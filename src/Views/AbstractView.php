<?php

namespace CubexBase\Application\Views;

use CubexBase\Application\AbstractBase;
use CubexBase\Application\Context\AppContext;
use Packaged\Context\Conditions\ExpectEnvironment;
use Packaged\Ui\TemplateLoaderTrait;

/**
 * @method AppContext getContext()
 */
abstract class AbstractView extends AbstractBase
{
  use TemplateLoaderTrait;

  public function shouldCache(): bool
  {
    return !$this->getContext()->matches(ExpectEnvironment::local());
  }

  public function getHeader(): ?AbstractBase { return null; }

  public function getFooter(): ?AbstractBase { return null; }
}
