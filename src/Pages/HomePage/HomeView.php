<?php

namespace CubexBase\Application\Pages\HomePage;

use Cubex\Mv\View;
use CubexBase\Application\Api\Modules\Example\Storage\Example;
use CubexBase\Application\Components\ButtonComponent;
use CubexBase\Application\Pages\AbstractView;
use CubexBase\Application\Pages\InvalidModelException;
use Packaged\Context\Context;
use Packaged\Glimpse\Tags\Text\HeadingOne;
use Packaged\Glimpse\Tags\Text\Paragraph;
use Packaged\SafeHtml\SafeHtml;

class HomeView extends AbstractView implements View
{
  public function setContext(Context $context): HomeView
  {
    $context->meta()->set('pageTitle', 'Home Page');
    $context->meta()->set('pageDescription', 'This is the home page');
    return parent::setContext($context);
  }

  public function getBlockName(): string
  {
    return 'home-page';
  }

  public function getModel(): ?HomeViewModel
  {
    if($this->_model instanceof HomeViewModel)
    {
      return $this->_model;
    }

    throw new InvalidModelException($this->_model, new HomeViewModel());
  }

  protected function _getContentForRender(): SafeHtml
  {
    $content = [];

    $content[] = HeadingOne::create($this->_('hello_world_b10a', 'Hello World'));
    $content[] = Paragraph::create('This is something');
    $content[] = ButtonComponent::withContext($this, 'Hello World');

    /** @var Example $example */
    foreach($this->getModel()->examples->examples as $example)
    {
      $content[] = Paragraph::create($example->title);
      $content[] = Paragraph::create($example->description);
    }

    return new SafeHtml(implode(PHP_EOL, $content));
  }
}
