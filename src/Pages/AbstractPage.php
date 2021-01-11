<?php


namespace CubexBase\Application\Pages;


use CubexBase\Application\AbstractBase;
use Packaged\Context\Context;

/**
 * Class AbstractPageClass
 * @package CubexBase\Application\Pages
 */
abstract class AbstractPage extends AbstractBase implements PageClass
{

  /**
   * @return string
   */
  public function getPageClass(): string
  {
    return $this->getBlockName();
  }

  /**
   * @return bool
   */
  public function shouldCache(): bool
  {
    return false;
  }

}
