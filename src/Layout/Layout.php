<?php


namespace CubexBase\Application\Layout;


use CubexBase\Application\Ui;
use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Dispatch\ResourceManager;
use Packaged\Dispatch\ResourceStore;
use Packaged\Ui\Element;
use PackagedUi\FontAwesome\FaIcon;
use Throwable;

/**
 * Class Layout
 * @package CubexBase\Application\Layout
 */
class Layout extends Element implements ContextAware
{

  use ContextAwareTrait;

  /** @var object */
  protected object $_content;
  /** @var string */
  private string $_pageClass;

  /**
   * @return string
   * @throws Throwable
   */
  public function render(): string
  {
    Ui::require();
    return parent::render();
  }

  /**
   * @return object
   */
  public function getContent()
  {
    return $this->_content;
  }

  /**
   * @param object $content
   * @return $this
   */
  public function setContent(object $content): self
  {
    $this->_content = $content;
    return $this;
  }

  /**
   * @return string
   */
  public function getPageClass(): string
  {
    if ($this->_pageClass) {
      return $this->_pageClass;
    }

    return '';
  }

  /**
   * @param string $pageClass
   * @return $this
   */
  public function setPageClass(string $pageClass): self
  {
    $this->_pageClass = $pageClass;
    return $this;
  }
}