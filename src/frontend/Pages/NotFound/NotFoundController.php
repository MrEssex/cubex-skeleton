<?php


namespace CubexBase\Frontend\Pages\NotFound;

use CubexBase\Frontend\Layout\LayoutController;

/**
 * Class NotFoundController
 * @package CubexBase\Frontend\Pages\NotFound
 */
class NotFoundController extends LayoutController
{
  /**
   * @return string
   */
  public function get(): string
  {
    return 'oops, not found';
  }
}
