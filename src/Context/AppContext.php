<?php

namespace CubexBase\Application\Context;

use Cubex\Context\Context;
use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\Context\Seo\SeoManager;
use Packaged\Http\LinkBuilder\LinkBuilder;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;

class AppContext extends Context implements Translatable
{
  use TranslatableTrait;
  use GetTranslatorTrait;

  protected ?SeoManager $_seo = null;

  /**
   * @param string   $path
   * @param string[] $query
   *
   * @return LinkBuilder
   */
  public function linkBuilder(string $path = '', array $query = []): LinkBuilder
  {
    return LinkBuilder::fromRequest($this->request(), $path, $query)->setSubDomain('www');
  }

  public function seo(): SeoManager
  {
    if($this->_seo === null)
    {
      // add defaults
      $seo = SeoManager::withContext($this);
      $seo->title($this->getSiteName());
      $seo->description($this->_('an_example_description_bb03', 'An example description'));
      $this->_seo = $seo;
    }

    return $this->_seo;
  }

  public function getSiteName()
  {
    return 'Cubex Base';
  }
}
