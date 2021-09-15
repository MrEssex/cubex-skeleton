<?php


namespace CubexBase\Frontend\Pages;


use CubexBase\Frontend\AbstractBase;

/**
 * Class AbstractPageClass
 * @package CubexBase\Frontend\Pages
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
