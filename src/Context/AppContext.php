<?php

namespace CubexBase\Application\Context;

use Cubex\I18n\GetTranslatorTrait;
use MrEssex\CubexInertiaJsProvider\InertiaContext;
use Packaged\Http\LinkBuilder\LinkBuilder;
use Packaged\I18n\TranslatableTrait;

class AppContext extends InertiaContext
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
}
