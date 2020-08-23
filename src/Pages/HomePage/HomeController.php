<?php


namespace FusionBase\Application\Pages\HomePage;


use FusionBase\Application\Layout\LayoutController;
use FusionBase\Application\Pages\HomePage\Ui\HomePage;

/**
 * Class HomeController
 * @package FusionBase\Application\Controller
 */
class HomeController extends LayoutController
{

  /**
   * @return HomePage
   */
  public function get()
  {
    return HomePage::withContext($this);
  }

}