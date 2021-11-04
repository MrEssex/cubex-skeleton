<?php

namespace CubexBase\Application\Context;

use Packaged\Http\LinkBuilder\LinkBuilder;

class Context extends \Cubex\Context\Context
{
  /**
   * @param string   $path
   * @param string[] $query
   *
   * @return LinkBuilder
   */
  public function linkBuilder(string $path = '', array $query = []): LinkBuilder
  {
    return LinkBuilder::fromRequest($this->request(), $path, $query);
  }
}
