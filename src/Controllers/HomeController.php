<?php

namespace CubexBase\Application\Controllers;

use CubexBase\Application\Pages\HomePage\HomePage;

class HomeController extends AbstractController
{
  public function get(): HomePage
  {
    return HomePage::withContext($this);
  }
}
