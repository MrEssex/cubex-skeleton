<?php

namespace CubexBase\Application\Http\Views\Error;

use CubexBase\Application\Http\Views\AbstractView;

class ErrorView extends AbstractView
{
  public function getBlockName(): string
  {
    return 'error';
  }
}
