<?php

namespace CubexBase\Frontend\Pages\HomePage;

use CubexBase\Frontend\Layout\LayoutController;

/**
 * Class HomeController
 * @package CubexBase\Frontend\Controller
 */
class HomeController extends LayoutController
{

  /**
   * @return HomePage
   */
  public function get(): HomePage
  {
    return HomePage::withContext($this);
  }

}
