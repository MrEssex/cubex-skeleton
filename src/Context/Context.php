<?php

namespace CubexBase\Application\Context;

use MrEssex\CubexInertiaJsProvider\InertiaContext;

class Context extends InertiaContext
{
  protected ?SeoMeta $_seoMeta = null;

  public function seoMeta(): SeoMeta
  {
    if($this->_seoMeta === null)
    {
      $this->_seoMeta = new SeoMeta();
    }

    return $this->_seoMeta;
  }
}
