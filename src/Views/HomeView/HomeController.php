<?php

namespace CubexBase\Application\Views\HomeView;

use CubexBase\Application\Layout\LayoutController;
use CubexBase\Application\Models\Game;

class HomeController extends LayoutController
{
  public function get()
  {
    $data = HomeViewModel::withContext($this);
    $games = Game::collection();
    $data->games = $games->load();
    return $data->setDefaultView(HomeView::class);
  }
}
