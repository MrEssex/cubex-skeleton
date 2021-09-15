<?php

namespace CubexBase\Frontend\Layout;

use CubexBase\Frontend\Ui;
use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Ui\Element;

class Layout extends Element implements ContextAware
{
  use ContextAwareTrait;

  protected object $_content;
  private string $_pageClass;

  public function render(): string
  {
    Ui::require();
    return parent::render();
  }

  public function getContent(): object
  {
    return $this->_content;
  }

  public function setContent(object $content): self
  {
    $this->_content = $content;
    return $this;
  }

  public function getPageClass(): string
  {
    if($this->_pageClass)
    {
      return $this->_pageClass;
    }

    return '';
  }

  public function setPageClass(string $pageClass): self
  {
    $this->_pageClass = $pageClass;
    return $this;
  }
}
