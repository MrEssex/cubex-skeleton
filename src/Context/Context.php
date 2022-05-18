<?php

namespace CubexBase\Application\Context;

use Cubex\Context\Context as CContext;
use Packaged\Http\LinkBuilder\LinkBuilder;

class Context extends CContext
{
  protected ?SeoMeta $_seoMeta = null;

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

  public function seoMeta(): SeoMeta
  {
    if($this->_seoMeta === null)
    {
      $this->_seoMeta = new SeoMeta();
    }

    return $this->_seoMeta;
  }
}
