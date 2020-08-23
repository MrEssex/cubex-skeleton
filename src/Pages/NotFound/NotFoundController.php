<?php


namespace FusionBase\Application\Pages\NotFound;

use FusionBase\Application\Layout\LayoutController;

/**
 * Class NotFoundController
 * @package FusionBase\Application\Pages\NotFound
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