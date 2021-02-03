<?php

namespace CubexBase\Application\Pages\HomePage\Ui;

use CubexBase\Application\Components\FeatherIcons\FeatherIcon;
use CubexBase\Application\Pages\AbstractPage;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\LineBreak;
use Packaged\Glimpse\Tags\Text\HeadingTwo;
use Packaged\Glimpse\Tags\Text\Paragraph;
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
   * @return HtmlTag|Div|array
   * @throws Throwable
   */
  protected function _getContentForRender()
  {
    return [
      Div::create($this->_('hello_world_b10a', 'Hello World')),
      LineBreak::create(),
      Paragraph::create(
        FeatherIcon::withContext($this, 'activity'),
        'This is something'
      ),
      HeadingTwo::create('User Ip Information'),
      json_encode($this->getContext()->ip()->getIpData(), JSON_THROW_ON_ERROR),
      LineBreak::create(),
      LineBreak::create(),
      HeadingTwo::create('User Device Information'),
      json_encode($this->getContext()->deviceInformation()->getDeviceDetector()->getClient(), JSON_THROW_ON_ERROR),
      json_encode($this->getContext()->deviceInformation()->getDeviceDetector()->getOs(), JSON_THROW_ON_ERROR),
    ];
  }
}
