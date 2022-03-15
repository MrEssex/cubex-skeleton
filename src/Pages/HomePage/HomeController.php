<?php

namespace CubexBase\Application\Pages\HomePage;

use CubexBase\Application\Layout\LayoutController;

class HomeController extends LayoutController
{
  public function get()
  {
    return HomeViewModel::withContext($this)->setDefaultView(HomeView::class);
  }
}
