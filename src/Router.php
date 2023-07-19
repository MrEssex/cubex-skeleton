<?php

namespace CubexBase\Application;

use CubexBase\Application\Layout\LayoutController;
use Exception;
use MrEssex\CubexInertiaJsProvider\InertiaController;

class Router extends LayoutController
{
  protected function _generateRoutes()
  {
    yield self::_route('/about', 'about');
    return ''; // Defaults to just 'get', 'put', 'post', 'delete'
  }

  /**
   * @throws Exception
   */
  public function get(): array
  {
    return InertiaController::withContext($this->getContext())->inertia('Home', ['name' => 'Arnold!']);
  }

  /**
   * @throws Exception
   */
  public function getAbout(): array
  {
    return InertiaController::withContext($this->getContext())->inertia('About', ['name' => 'About me help']);
  }
}
