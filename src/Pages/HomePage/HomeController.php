<?php

namespace CubexBase\Application\Pages\HomePage;

use CubexBase\Application\Layout\LayoutController;

class HomeController extends LayoutController
{
  public function get()
  {
    $data = HomeViewModel::withContext($this);
    return $data->setDefaultView(HomeView::class);
  }
}
