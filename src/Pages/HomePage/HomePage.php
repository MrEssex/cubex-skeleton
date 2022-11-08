<?php

namespace CubexBase\Application\Pages\HomePage;

use CubexBase\Application\Context\SeoMeta;
use CubexBase\Application\Pages\AbstractPage;

class HomePage extends AbstractPage
{
  protected function _seoMeta(SeoMeta $seoMeta): void
  {
    $seoMeta->setTitle('Home Page');
    $seoMeta->setDescription('This is the home page');
    $seoMeta->setKeywords(['home', 'page']);
    parent::_seoMeta($seoMeta);
  }

  public function getBlockName(): string
  {
    return 'home-page';
  }
}
