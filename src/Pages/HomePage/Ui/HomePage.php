<?php

namespace CubexBase\Application\Pages\HomePage\Ui;

use CubexBase\Application\Pages\AbstractPage;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Tags\Div;
use Throwable;

/**
 * Class HomePage
 * @package CubexBase\Application\Pages\HomePage
 */
class HomePage extends AbstractPage
{

  /**
   * @return string
   */
  public function getBlockName(): string
  {
    return 'homepage';
  }

  /**
   * @return HtmlTag|Div
   * @throws Throwable
   */
  protected function _getContentForRender()
  {
    return Div::create($this->_('hello_world_b10a', 'Hello World'));
  }

  public function shouldCache(): bool
  {
    return false;
  }
}
