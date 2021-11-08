<?php
namespace CubexBase\Application\Layout;

use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Dispatch\ResourceManager;
use Packaged\Ui\Element;

class Layout extends Element implements ContextAware
{
  use ContextAwareTrait;

  /** @var mixed */
  protected $_content;
  private string $_pageClass = "";

  public function render(): string
  {
    ResourceManager::resources()->requireCss('main.min.css');
    ResourceManager::resources()->requireJs('main.min.js');
    return parent::render();
  }

  public function getContent()
  {
    return $this->_content;
  }

  public function setContent($content): self
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
