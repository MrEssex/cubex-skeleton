<?php

namespace CubexBase\Application\Http;

interface CachablePage
{
  public function shouldCache(): bool;
}
