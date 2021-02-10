<?php

namespace CubexBase\Application\Pages\HomePage;

use CubexBase\Application\Layout\LayoutController;

/**
 * Class HomeController
 * @package CubexBase\Application\Controller
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
