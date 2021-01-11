<?php

namespace CubexBase\Application\Context;

use Packaged\Config\Provider\Ini\IniConfigProvider;
use Packaged\Dal\DalResolver;
use Packaged\Http\LinkBuilder\LinkBuilder;

/**
 * Class Context
 * @package CubexBase\Application
 */
class Context extends \Cubex\Context\Context
{

  /**
   * CliContext Constructor.
   */
  protected function _construct()
  {
    parent::_construct();
    (new DalResolver(
      new IniConfigProvider($this->getProjectRoot() . '/conf/connections.ini'),
      new IniConfigProvider($this->getProjectRoot() . '/conf/datastores.ini')
    ))->boot();
  }

  /**
   * @param string $path
   * @param array  $query
   *
   * @return LinkBuilder
   */
  public function linkBuilder($path = '', $query = []): LinkBuilder
  {
    return LinkBuilder::fromRequest($this->request(), $path, $query);
  }

}
