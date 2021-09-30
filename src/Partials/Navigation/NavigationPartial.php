<?php

namespace CubexBase\Application\Partials\Navigation;

use CubexBase\Application\Partials\AbstractPartial;

class NavigationPartial extends AbstractPartial
{
  public function getBlockName(): string
  {
    return 'navigation';
  }

  protected function _getContentForRender()
  {
    return parent::_getContentForRender();
  }
}
