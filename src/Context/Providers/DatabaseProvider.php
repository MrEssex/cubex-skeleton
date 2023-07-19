<?php

namespace CubexBase\Application\Context\Providers;

use Packaged\Config\Provider\Ini\IniConfigProvider;
use Packaged\Dal\DalResolver;

class DatabaseProvider extends AbstractProvider
{
  protected bool $_configured = false;

  public function registerDatabaseConnections(string $environment = 'local'): static
  {
    if(!$this->_configured)
    {
      $this->_configured = true;
      $dal = new DalResolver(
        (new IniConfigProvider())->loadFiles(
          [
            $this->getContext()->getProjectRoot() . '/conf/connections.ini',
            $this->getContext()->getProjectRoot() . "/conf/{$environment}/connections.ini",
          ]
        ),
        (new IniConfigProvider())->loadFiles(
          [
            $this->getContext()->getProjectRoot() . '/conf/datastores.ini',
            $this->getContext()->getProjectRoot() . "/conf/{$environment}/datastores.ini",
          ]
        ),
      );
      $dal->boot();
    }
    return $this;
  }
}
