<?php

namespace CubexBase\Application\Pages;

interface CachablePage
{
  public function shouldCache(): bool;
}
