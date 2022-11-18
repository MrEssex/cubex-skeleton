<?php

namespace CubexBase\Application\Http\Home;

use CubexBase\Application\Http\Home\HomePage\HomePage;
use CubexBase\Application\Layout\LayoutController;

class HomeController extends LayoutController
{
  /**
   * Get the Home Page
   * Do all the controller logic in here such as getting model info and doing calculations
   *
   * @return HomePage
   */
  public function get()
  {
    return HomePage::withContext($this);
  }
}
