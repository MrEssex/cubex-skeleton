<?php

namespace CubexBase\Application\Http\Middleware;

use Packaged\Http\Responses\RedirectResponse;

class ExampleMiddleware extends AbstractMiddleware
{
  public function process(&$response): bool
  {
    $response = RedirectResponse::create('/');
    return false;
  }
}
