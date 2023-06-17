<?php
namespace CubexBase\Application\Layout;

use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Partials\Footer\FooterPartial;
use CubexBase\Application\Partials\Header\HeaderPartial;
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

  protected mixed $_content;
  protected string $_pageClass = "";
  protected mixed $_header;
  protected mixed $_footer;

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
    if($this->_pageClass !== '' && $this->_pageClass !== '0')
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

  public function getHeader()
  {
    return $this->_header ?? HeaderPartial::withContext($this);
  }

  public function getFooter()
  {
    return $this->_footer ?? FooterPartial::withContext($this);
  }

  public function setHeader($header): static
  {
    if($header !== null)
    {
      $this->_header = $header;
    }
    return $this;
  }

  public function setFooter($footer): static
  {
    if($footer !== null)
    {
      $this->_footer = $footer;
    }
    return $this;
  }
}
