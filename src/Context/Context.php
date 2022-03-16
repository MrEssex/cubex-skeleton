<?php

namespace CubexBase\Application\Context;

use Cubex\Context\Context as CContext;
use Packaged\Config\Provider\Ini\IniConfigProvider;
use Packaged\Context\Conditions\ExpectEnvironment;
use Packaged\Dal\DalResolver;
use Packaged\Http\LinkBuilder\LinkBuilder;

class Context extends CContext
{
  protected bool $_dbConfigured = false;

  protected function _initialize(): void
  {
    parent::_initialize();
    $this->registerDatabaseConnections($this->matches(ExpectEnvironment::local()) ? 'local' : $this->getEnvironment());
  }

  /**
   * @param string $path
   * @param string[] $query
   *
   * @return LinkBuilder
   */
  public function linkBuilder(string $path = '', array $query = []): LinkBuilder
  {
    return LinkBuilder::fromRequest($this->request(), $path, $query);
  }

  /**
   * @param string $environment
   *
   * @return $this
   */
  public function registerDatabaseConnections(string $environment = 'local')
  {
    if(!$this->_dbConfigured)
    {
      $this->_dbConfigured = true;
      $dal = new DalResolver(
        (new IniConfigProvider())->loadFiles(
          [
            $this->getProjectRoot() . '/conf/connections.ini',
            $this->getProjectRoot() . "/conf/{$environment}connections.ini",
          ]
        ),
        (new IniConfigProvider())->loadFiles(
          [
            $this->getProjectRoot() . '/conf/datastores.ini',
            $this->getProjectRoot() . "/conf/{$environment}datastores.ini",
          ]
        ),
      );
      $dal->boot();
    }

    return $this;
  }
}
