<?php

namespace CubexBase\Application\Pages;

use CubexBase\Application\AbstractBase;
use CubexBase\Application\Context\SeoMeta;
use Packaged\Context\Conditions\ExpectEnvironment;
use Packaged\Context\Context;

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

  public function setContext(Context $context): AbstractPage
  {
    if($context instanceof \CubexBase\Application\Context\Context)
    {
      $this->_seoMeta($context->seoMeta());
    }

    return parent::setContext($context);
  }

  protected function _seoMeta(SeoMeta $seoMeta): void
  {
  }
}
