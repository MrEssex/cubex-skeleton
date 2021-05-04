<?php

namespace CubexBase\Application\Layout;

use Exception;
use Packaged\Dispatch\ResourceManager;

/**
 * Class Ui
 *
 * @package CubexBase\Application
 */
class Ui
{
  /** @var string */
  public const FILE_BASE_CSS = 'main.min.css';
  /** @var string */
  public const FILE_BASE_JS = 'main.min.js';

  /**
   * @throws Exception
   */
  public static function require(): void
  {
    static::requireCss();
    static::requireJs();
  }

  /**
   * @throws Exception
   */
  public static function requireCss(): void
  {
    ResourceManager::resources()->requireCss(self::FILE_BASE_CSS);
  }

  /**
   * @throws Exception
   */
  public static function requireJs(): void
  {
    ResourceManager::resources()->requireJs(self::FILE_BASE_JS);
  }
}
