<?php
namespace CubexBase\Application\Views\HomeView;

use Cubex\Mv\ViewModel;
use CubexBase\Application\Models\Game;

class HomeViewModel extends ViewModel
{
  /** @var Game */
  public $games;
}
