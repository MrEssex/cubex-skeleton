<?php
namespace CubexBase\Application\Http\Partials\Footer;

use CubexBase\Application\Http\AbstractBase;
use Packaged\SafeHtml\SafeHtml;

class FooterPartial extends AbstractBase
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
