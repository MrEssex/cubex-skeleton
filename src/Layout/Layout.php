<?php
namespace CubexBase\Application\Layout;

use CubexBase\Application\Context\AppContext;
use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\Dispatch\ResourceManager;
use Packaged\Ui\Element;
use RuntimeException;

class Layout extends Element implements ContextAware, WithContext
{
  use ContextAwareTrait;
  use WithContextTrait;

  /** @var mixed */
  public $pageData;

  public function getContext(): AppContext
  {
    if($this->_context instanceof AppContext)
    {
      return $this->_context;
    }

    throw new RuntimeException('Invalid Context Passed through');
  }

  public function render(): string
  {
    ResourceManager::resources()->requireCss('main.min.css');
    ResourceManager::resources()->requireJs('main.min.js');
    return parent::render();
  }

  /**
   * @throws \JsonException
   */
  public function getPageData()
  {
    return htmlspecialchars(json_encode($this->pageData, JSON_THROW_ON_ERROR), ENT_QUOTES);
  }
}
