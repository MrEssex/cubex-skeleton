<?php
namespace CubexBase\Application\Http\Components\Footer;

use CubexBase\Application\Http\AbstractBase;
use Packaged\SafeHtml\SafeHtml;

class Footer extends AbstractBase
{
  protected $_tag = 'footer';

  public function getBlockName(): string
  {
    return 'primary-footer';
  }

  protected function _getContentForRender(): SafeHtml
  {
    return SafeHtml::escape('This is the footer');
  }
}
