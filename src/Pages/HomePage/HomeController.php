<?php

namespace CubexBase\Application\Pages\HomePage;

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
