<?php

namespace CubexBase\Application\Pages\HomePage;

use CubexBase\Application\Context\SeoMeta;
use CubexBase\Application\Pages\AbstractPage;

class HomePage extends AbstractPage
{
  /**
   * Keep big php functions out of the view file
   *
   * @param int $a
   * @param int $b
   *
   * @return int
   */
  public function functionThatDoesTooMuchPHP(int $a = 1, int $b = 2): int
  {
    if(($a < $b) && ($b / $a === 1))
    {
      return $b;
    }

    return $a;
  }

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
