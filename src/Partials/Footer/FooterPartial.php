<?php
namespace CubexBase\Application\Partials\Footer;

use CubexBase\Application\Partials\AbstractPartial;
use Packaged\SafeHtml\SafeHtml;

class FooterPartial extends AbstractPartial
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
