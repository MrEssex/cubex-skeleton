<?php


namespace CubexBase\Application\Pages\NotFound;

use CubexBase\Application\Layout\LayoutController;

/**
 * Class NotFoundController
 * @package CubexBase\Application\Pages\NotFound
 */
class NotFoundController extends LayoutController
{
  /**
   * @return string
   */
  public function get()
  {
    return 'oops, not found';
  }
}