<?php

namespace CubexBase\Application\Http\Home\HomePage;

use CubexBase\Application\Context\Seo\SeoManager;
use CubexBase\Application\Http\AbstractPage;

class HomePage extends AbstractPage
{
  protected function _seo(SeoManager $seoMeta): void
  {
    $seoMeta->title($this->getContext()->getSiteName() . ' - Home Page');
    parent::_seo($seoMeta);
  }

  public function getBlockName(): string
  {
    return 'home-page';
  }
}
