<?php

namespace CubexBase\Application\Http\Middleware;

use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;

abstract class AbstractMiddleware implements ContextAware
{
  use ContextAwareTrait;

  abstract public function process(&$response): bool;
}
