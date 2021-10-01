<?php

namespace CubexBase\Application\Pages\NotFoundPage;

use CubexBase\Application\Layout\LayoutController;
use Packaged\Http\Response;

class NotFoundController extends LayoutController
{
  public function get()
  {
    return Response::create('oops, not found', 404);
  }
}
