<?php

namespace CubexBase\Application\Context;

use Cubex\Context\Context as CContext;
use Packaged\Http\LinkBuilder\LinkBuilder;
use CubexBase\Application\Inertia\Inertia;

class Context extends CContext
{
  protected Inertia $_inertia;

  protected function _construct()
  {
    $this->_inertia = Inertia::withContext($this);
    parent::_construct();
  }

  public function inertia()
  {
    return $this->_inertia;
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
