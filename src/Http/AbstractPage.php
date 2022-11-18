<?php

namespace CubexBase\Application\Http;

use CubexBase\Application\AbstractBase;
use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Context\Seo\SeoManager;
use Packaged\Context\Conditions\ExpectEnvironment;
use Packaged\Ui\Html\HtmlElement;

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

  public function getHeader(): ?AbstractBase { return null; }

  public function getFooter(): ?AbstractBase { return null; }

  protected function _prepareForProduce(): HtmlElement
  {
    if($this->getContext() instanceof AppContext)
    {
      $this->_seo($this->getContext()->seo());
    }
    return parent::_prepareForProduce();
  }

  protected function _seo(SeoManager $seoMeta): void
  {
    $seoMeta->title($this->getContext()->getSiteName());
    $seoMeta->description($this->_('default_site_description_a3f4', 'Default Site Description'));
    $seoMeta->viewport('width=device-width, initial-scale=1');
    $seoMeta->themeColor('#fafafa');
  }
}
