<?php

namespace CubexBase\Application\Http\Home\HomePage;

use CubexBase\Application\Context\Seo\SeoManager;
use CubexBase\Application\Http\AbstractPage;

class HomePage extends AbstractPage
{
  protected function _seo(SeoManager $seoMeta): void
  {
    parent::_seo($seoMeta);
    $seoMeta->title($this->getContext()->getSiteName() . ' - Home Page');
  }

  public function getBlockName(): string
  {
    return 'home-page';
  }
}
