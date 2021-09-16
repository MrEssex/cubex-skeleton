<?php

namespace CubexBase\Application\Pages\NotFound;

use CubexBase\Application\Layout\LayoutController;

class NotFoundController extends LayoutController
{
  public function get(): string
  {
    return 'oops, not found';
  }
}
