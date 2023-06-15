<?php
namespace CubexBase\Application\Components\Button;

use CubexBase\Application\AbstractBase;
use Packaged\SafeHtml\SafeHtml;

class Button extends AbstractBase
{
  protected $_tag = 'button';
  protected ?string $_content;

  public function __construct($content)
  {
    parent::__construct();
    $this->_content = $content;
  }

  public function getBlockName(): string
  {
    return 'btn';
  }

  protected function _getContentForRender(): SafeHtml
  {
    return new SafeHtml($this->_content);
  }
}
