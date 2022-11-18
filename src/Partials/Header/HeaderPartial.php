<?php
namespace CubexBase\Application\Partials\Header;

use CubexBase\Application\Partials\AbstractPartial;
use Packaged\SafeHtml\SafeHtml;

class HeaderPartial extends AbstractPartial
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
