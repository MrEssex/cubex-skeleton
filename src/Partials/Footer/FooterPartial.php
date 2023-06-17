<?php
namespace CubexBase\Application\Partials\Footer;

use CubexBase\Application\AbstractBase;
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
