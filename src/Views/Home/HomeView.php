<?php

namespace CubexBase\Application\Views\Home;

use CubexBase\Application\Views\AbstractView;

/**
 * @property HomeViewModel $_model
 */
class HomeView extends AbstractView
{
  public function getBlockName(): string
  {
    return 'home';
  }
}
