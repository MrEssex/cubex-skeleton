<?php
namespace CubexBase\Application\Components;

class ButtonComponent extends AbstractComponent
{
  protected $_tag = 'button';

  public function getBlockName(): string
  {
    return 'btn';
  }
}
