<?php

namespace CubexBase\Application\Cli;

use CubexBase\Application\I18n\TranslateCommand;

class Translate extends TranslateCommand
{
  protected function _translationsDir(): string
  {
    return dirname(__DIR__, 3) . '/translations/';
  }
}
