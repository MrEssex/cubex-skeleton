<?php

namespace CubexBase\Frontend\Pages\NotFound;

use CubexBase\Frontend\Layout\LayoutController;

class NotFoundController extends LayoutController
{
  public function get(): string
  {
    return 'oops, not found';
  }
}
