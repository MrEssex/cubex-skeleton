<?php

namespace CubexBase\Application\Pages\HomePage;

use CubexBase\Application\Layout\LayoutController;
use CubexBase\Application\Pages\HomePage\Ui\HomePage;

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
