<?php

namespace CubexBase\Application\Views;

interface CachableView
{
  public function shouldCache(): bool;
}
