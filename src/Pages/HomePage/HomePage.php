<?php

namespace CubexBase\Application\Pages\HomePage;

use CubexBase\Application\Components\ButtonComponent;
use CubexBase\Application\Context\SeoMeta;
use CubexBase\Application\Pages\AbstractPage;
use Packaged\Glimpse\Tags\Text\HeadingOne;
use Packaged\Glimpse\Tags\Text\Paragraph;
use Packaged\SafeHtml\SafeHtml;

class HomePage extends AbstractPage
{
  protected function _seoMeta(SeoMeta $seoMeta)
  {
    $seoMeta->setTitle('Home Page');
    $seoMeta->setDescription('This is the home page');
    return parent::_seoMeta($seoMeta);
  }

  public function getBlockName(): string
  {
    return 'home-page';
  }

  protected function _getContentForRender(): SafeHtml
  {
    $content = [];

    $content[] = HeadingOne::create($this->_('hello_world_b10a', 'Hello World'));
    $content[] = Paragraph::create('This is something');
    $content[] = ButtonComponent::withContext($this, 'Hello World');

    return new SafeHtml(implode(PHP_EOL, $content));
  }
}
