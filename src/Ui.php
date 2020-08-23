<?php


namespace CubexBase\Application;


use Cubex\Cubex;
use Exception;
use Packaged\Dispatch\ResourceManager;

use function strpos;

/**
 * Class Ui
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
    if (
      strpos(Cubex::instance()->getContext()->request()->userAgent(), 'Trident/') > -1
      || strpos(Cubex::instance()->getContext()->request()->userAgent(), 'Edge/') > -1) {
      ResourceManager::resources()->requireCss('main.ie.min.css');
    }
    else {
      ResourceManager::resources()->requireCss(self::FILE_BASE_CSS);
    }
  }

  /**
   * @throws Exception
   */
  public static function requireJs(): void
  {
    if (
      strpos(Cubex::instance()->getContext()->request()->userAgent(), 'Trident/') > -1
      || strpos(Cubex::instance()->getContext()->request()->userAgent(), 'Edge/') > -1) {
      ResourceManager::resources()->requireJs('main.ie.min.js');
    }
    else {
      ResourceManager::resources()->requireJs(self::FILE_BASE_JS);
    }
  }
}