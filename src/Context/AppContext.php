<?php

namespace CubexBase\Application\Context;

use Cubex\Context\Context;
use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\Context\Providers\FlashMessageProvider;
use Packaged\Http\LinkBuilder\LinkBuilder;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;

class AppContext extends Context implements Translatable
{
  use TranslatableTrait;
  use GetTranslatorTrait;

  protected ?FlashMessageProvider $flash = null;

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

  public function flash(): FlashMessageProvider
  {
    if($this->flash === null)
    {
      $this->flash = FlashMessageProvider::hydrateFromRequest($this->request());
    }

    return $this->flash;
  }
}
