<?php

namespace CubexBase\Frontend\Pages\HomePage;

use CubexBase\Frontend\Pages\AbstractPage;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Text\Paragraph;
use Throwable;

/**
 * Class HomePage
 *
 * @package CubexBase\Frontend\Pages\HomePage
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
   * @return array
   * @throws Throwable
   */
  protected function _getContentForRender(): array
  {
    return [
      Div::create($this->_('hello_world_b10a', 'Hello World')),
      Paragraph::create('This is something'),
    ];
  }
}
