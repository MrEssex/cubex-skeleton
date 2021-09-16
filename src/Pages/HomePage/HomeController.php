<?php

namespace CubexBase\Application\Pages\HomePage;

use CubexBase\Application\Layout\LayoutController;

class HomeController extends LayoutController
{
  public function get(): HomePage
  {
    return HomePage::withContext($this);
  }
}
