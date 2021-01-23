<?php

namespace CubexBase\Application\Cli;

use CubexBase\Application\I18n\TranslateCommand;

/**
 * Class Translate
 * @package CubexBase\Application\Cli
 */
class Translate extends TranslateCommand
{

  /**
   * @return string
   */
  protected function _translationsDir(): string
  {
    return dirname(__DIR__, 2) . '/translations/';
  }
}
