<?php

namespace CubexBase\Application\Http\Views;

use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Http\AbstractBase;
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
