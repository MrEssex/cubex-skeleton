<?php

namespace CubexBase\Application\Views\HomeView;

use Cubex\Mv\Model;
use Cubex\Mv\View;
use CubexBase\Application\Views\AbstractView;
use Packaged\Context\Context;
use Packaged\Glimpse\Tags\Text\HeadingOne;
use Packaged\Glimpse\Tags\Text\Paragraph;
use Packaged\SafeHtml\SafeHtml;

class HomeView extends AbstractView implements View
{
  /** @var Model|null|HomeViewModel */
  protected ?Model $_model;

  public function __construct(?Model $data)
  {
    $this->_model = $data;
    parent::__construct();
  }

  public function setContext(Context $context)
  {
    $context->meta()->set('pageTitle', 'Home Page');
    $context->meta()->set('pageDescription', 'This is the home page');
    return parent::setContext($context);
  }

  public function getBlockName(): string
  {
    return 'home-page';
  }

  protected function _getContentForRender()
  {
    $content = [];

    $content[] = HeadingOne::create($this->_('hello_world_b10a', 'Hello World'));
    $content[] = Paragraph::create('This is something');

    return new SafeHtml(implode(PHP_EOL, $content));
  }
}
