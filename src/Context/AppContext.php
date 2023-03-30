<?php

namespace CubexBase\Application\Context;

use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\Context\Seo\SeoManager;
use MrEssex\CubexInertiaJsProvider\InertiaContext;
use Packaged\Http\LinkBuilder\LinkBuilder;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;

class AppContext extends InertiaContext implements Translatable
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
      $this->_seo = SeoManager::withContext($this);
    }

    return $this->_seo;
  }

  public function getSiteName(): string
  {
    return 'Cubex Base';
  }
}
