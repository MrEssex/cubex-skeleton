<?php
namespace CubexBase\Application\Components;

class ButtonComponent extends AbstractComponent
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

  protected function _getContentForRender(): ?string
  {
    return $this->_content;
  }
}
