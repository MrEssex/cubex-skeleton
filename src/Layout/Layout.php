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
  protected $_content;

  /**
   * @return string
   * @throws Throwable
   */
  public function render(): string
  {
    Ui::require();
    ResourceManager::vendor('packaged-ui', 'fontawesome')->requireCss(
      FaIcon::CSS_PATH,
      null,
      ResourceStore::PRIORITY_LOW
    );
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
  public function setContent(object $content)
  {
    $this->_content = $content;
    return $this;
  }
}