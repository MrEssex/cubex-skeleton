<?php

namespace CubexBase\Frontend\Pages\HomePage;

use CubexBase\Frontend\Layout\LayoutController;

class HomeController extends LayoutController
{
  public function get(): HomePage
  {
    return HomePage::withContext($this);
  }
}
