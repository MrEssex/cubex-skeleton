<?php

namespace CubexBase\Application\Controllers;

class NotFoundController extends AbstractController
{
  public function get(): string
  {
    return 'oops, not found';
  }
}
