<?php

namespace CubexBase\Application\Pages\HomePage;

use CubexBase\Application\Pages\AbstractPage;

class HomePage extends AbstractPage
{
  public function getBlockName(): string
  {
    return 'home-page';
  }
}
