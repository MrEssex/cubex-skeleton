<?php

namespace CubexBase\Application\Views\Home;

use CubexBase\Application\Views\AbstractView;

class HomeView extends AbstractView
{
  public function getBlockName(): string
  {
    return 'home';
  }
}
