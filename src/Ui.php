<?php


namespace FusionBase\Application;


use Cubex\Cubex;
use Exception;
use Packaged\Dispatch\ResourceManager;
use PackagedUi\Fusion\Fusion;

use function strpos;

/**
 * Class Ui
 * @package FusionBase\Application
 */
class Ui extends Fusion
{
  /** @var string */
  const FILE_BASE_CSS = 'reviewed.min.css';
  /** @var string */
  const FILE_BASE_JS = 'reviewed.min.js';

  /**
   * @throws Exception
   */
  public static function requireCss()
  {
    if (
      strpos(Cubex::instance()->getContext()->request()->userAgent(), 'Trident/') > -1
      || strpos(Cubex::instance()->getContext()->request()->userAgent(), 'Edge/') > -1) {
      ResourceManager::resources()->requireCss('reviewed.ie.min.css');
    }
    else {
      ResourceManager::resources()->requireCss(self::FILE_BASE_CSS);
    }
  }

  /**
   * @throws Exception
   */
  public static function requireJs()
  {
    if (
      strpos(Cubex::instance()->getContext()->request()->userAgent(), 'Trident/') > -1
      || strpos(Cubex::instance()->getContext()->request()->userAgent(), 'Edge/') > -1) {
      ResourceManager::resources()->requireJs('reviewed.ie.min.js');
    }
    else {
      ResourceManager::resources()->requireJs(self::FILE_BASE_JS);
    }
  }
}