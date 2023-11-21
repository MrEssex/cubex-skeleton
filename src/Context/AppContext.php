<?php

namespace CubexBase\Application\Context;

use Cubex\Context\Context;
use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\Context\Providers\DatabaseProvider;
use CubexBase\Application\Context\Providers\FlashMessageProvider;
use CubexBase\Application\Context\Providers\SeoProvider;
use Packaged\Http\LinkBuilder\LinkBuilder;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;

class AppContext extends Context implements Translatable
{
  use TranslatableTrait;
  use GetTranslatorTrait
  {
    GetTranslatorTrait::_getTranslator insteadof TranslatableTrait;
  }

  protected function _initialize(): void
  {
    parent::_initialize();
    $cubex = @$this->getCubex();

    //Register the database
    $databaseProvider = DatabaseProvider::instance($this);
    $databaseProvider->registerDatabaseConnections($this->getEnvironment());

    $cubex->share(SeoProvider::class, SeoProvider::instance($this));
    $cubex->share(DatabaseProvider::class, $databaseProvider);
    $cubex->share(FlashMessageProvider::class, FlashMessageProvider::instance($this, $this->request()));
  }

  /**
   * @param string   $path
   * @param string[] $query
   *
   * @return LinkBuilder
   */
  public function www(string $path = '', array $query = []): LinkBuilder
  {
    return LinkBuilder::fromRequest($this->request(), $path, $query)->setSubDomain('www');
  }
}
