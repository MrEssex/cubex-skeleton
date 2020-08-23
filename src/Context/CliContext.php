<?php


namespace FusionBase\Application\Context;

use Packaged\Config\Provider\Ini\IniConfigProvider;
use Packaged\Dal\DalResolver;

/**
 * Class CliContext
 * @package FusionBase\Application\Context
 */
class CliContext extends Context
{

  /**
   * CliContext Constructor.
   */
  protected function _construct()
  {
    parent::_construct();
    //Setup Dal
    (new DalResolver(
      new IniConfigProvider($this->getProjectRoot() . '/conf/connections.ini'),
      new IniConfigProvider($this->getProjectRoot() . '/conf/datastores.ini')
    ))->boot();
  }

}