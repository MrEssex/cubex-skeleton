<?php
namespace CubexBase\Application\Http\Components\Header;

use CubexBase\Application\Http\AbstractBase;
use Packaged\SafeHtml\SafeHtml;

class Header extends AbstractBase
{
  protected $_tag = 'header';

  public function getBlockName(): string
  {
    return 'primary-header';
  }

  protected function _getContentForRender(): SafeHtml
  {
    return SafeHtml::escape('This is the header');
  }
}
