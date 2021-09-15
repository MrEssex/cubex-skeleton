<?php

namespace CubexBase\Shared\Cli;

use CubexBase\Shared\I18n\TranslateCommand;

class Translate extends TranslateCommand
{
  /**
   * @return string
   */
  protected function _translationsDir(): string
  {
    return dirname(__DIR__, 3) . '/translations/';
  }
}
