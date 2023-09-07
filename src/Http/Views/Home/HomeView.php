<?php

namespace CubexBase\Application\Http\Views\Home;

use CubexBase\Application\Http\Views\AbstractView;

class HomeView extends AbstractView
{
  public function getBlockName(): string
  {
    return 'home';
  }
}
