<?php

namespace CubexBase\Frontend;

use Packaged\Dispatch\ResourceManager;

class Ui
{
  public const FILE_BASE_CSS = 'main.min.css';
  public const FILE_BASE_JS = 'main.min.js';

  public static function require(): void
  {
    static::requireCss();
    static::requireJs();
  }

  public static function requireCss(): void
  {
    ResourceManager::resources()->requireCss(self::FILE_BASE_CSS);
  }

  public static function requireJs(): void
  {
    ResourceManager::resources()->requireJs(self::FILE_BASE_JS);
  }
}
