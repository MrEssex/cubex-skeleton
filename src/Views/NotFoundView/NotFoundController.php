<?php

namespace CubexBase\Application\Views\NotFoundView;

use CubexBase\Application\Layout\LayoutController;
use Packaged\Http\Response;

class NotFoundController extends LayoutController
{
  public function get(): Response
  {
    return Response::create('oops, not found', 404);
  }
}
