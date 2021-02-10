<?php

namespace CubexBase\Application\Context;

use Packaged\Http\LinkBuilder\LinkBuilder;

/**
 * Class Context
 * @package CubexBase\Application
 */
class Context extends \Cubex\Context\Context
{

  /**
   * @param string $path
   * @param array $query
   *
   * @return LinkBuilder
   */
  public function linkBuilder($path = '', $query = []): LinkBuilder
  {
    return LinkBuilder::fromRequest($this->request(), $path, $query);
  }

}
