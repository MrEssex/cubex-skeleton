<?php

namespace CubexBase\Shared\Cli;

use CubexBase\Shared\I18n\PoToArrayCommand;

class Potoar extends PoToArrayCommand
{
  protected function _translationsDir(): string
  {
    return dirname(__DIR__, 3) . '/translations/';
  }
}
