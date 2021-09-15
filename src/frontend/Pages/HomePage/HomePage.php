<?php

namespace CubexBase\Frontend\Pages\HomePage;

use CubexBase\Frontend\Pages\AbstractPage;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Text\Paragraph;

class HomePage extends AbstractPage
{

  public function getBlockName(): string
  {
    return 'homepage';
  }

  protected function _getContentForRender(): array
  {
    return [
      Div::create($this->_('hello_world_b10a', 'Hello World')),
      Paragraph::create('This is something'),
    ];
  }
}
