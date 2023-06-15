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

  public function getSiteName(): string
  {
    return 'Cubex Base';
  }
}
