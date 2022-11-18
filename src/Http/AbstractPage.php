<?php

namespace CubexBase\Application\Http;

use CubexBase\Application\AbstractBase;
use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Context\Seo\SeoManager;
use Packaged\Context\Conditions\ExpectEnvironment;
use Packaged\Context\Context;

abstract class AbstractPage extends AbstractBase implements PageClass, CachablePage
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
    parent::setContext($context);

    if($context instanceof AppContext)
    {
      $this->_seo($context->seo());
    }

    return $this;
  }

  protected function _seo(SeoManager $seoMeta): void { }

  public function getHeader(): ?AbstractBase { return null; }

  public function getFooter(): ?AbstractBase { return null; }
}