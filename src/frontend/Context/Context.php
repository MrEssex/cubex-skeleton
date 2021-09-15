<?php

namespace CubexBase\Frontend\Context;

use Packaged\Http\LinkBuilder\LinkBuilder;

class Context extends \Cubex\Context\Context
{

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
