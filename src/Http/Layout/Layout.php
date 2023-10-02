<?php
namespace CubexBase\Application\Http\Layout;

use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Http\Components\Footer\Footer;
use CubexBase\Application\Http\Components\Header\Header;
use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\Dispatch\ResourceManager;
use Packaged\Ui\Element;

/**
 * @method AppContext getContext();
 */
class Layout extends Element implements ContextAware, WithContext
{
  use ContextAwareTrait;
  use WithContextTrait;

  protected mixed $_content;
  protected string $_pageClass = "";
  protected mixed $_header;
  protected mixed $_footer;

  public function __construct()
  {
    // Require default resources
    ResourceManager::resources()->requireCss('main.min.css');
    ResourceManager::resources()->requireJs('main.min.js');
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
    return $this->_header ?? Header::withContext($this);
  }

  public function getFooter()
  {
    return $this->_footer ?? Footer::withContext($this);
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
