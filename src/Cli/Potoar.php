<?php

namespace CubexBase\Application\Cli;

use CubexBase\Application\I18n\PoToArrayCommand;

/**
 * Class Potoar
 * @package CubexBase\Application\Cli
 */
class Potoar extends PoToArrayCommand
{

  /**
   * @return string
   */
  protected function _translationsDir(): string
  {
    return dirname(__DIR__, 2) . '/translations/';
  }
}
