<?php


namespace FusionBase\Application\Pages\HomePage\Ui;


use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Tags\Div;
use Packaged\Ui\Html\TemplatedHtmlElement;
use PackagedUi\BemComponent\BemComponent;
use PackagedUi\BemComponent\BemComponentTrait;
use Throwable;

/**
 * Class HomePage
 * @package FusionBase\Application\Pages\HomePage
 */
class HomePage extends TemplatedHtmlElement implements WithContext, ContextAware, BemComponent
{
  use BemComponentTrait;
  use ContextAwareTrait;
  use WithContextTrait;

  /**
   * HomePage constructor.
   */
  public function __construct()
  {
    $this->addClass($this->getBlockName());
  }

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
    return Div::create('Hello World');
  }
}