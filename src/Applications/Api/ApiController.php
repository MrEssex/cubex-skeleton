<?php

namespace CubexBase\Application\Applications\Api;

use Cubex\ApiFoundation\Controller\ApiController as CubexApiController;
use CubexBase\Application\Applications\Api\Modules\Test\TestModule;
use Generator;

/**
 * Class ApiController
 *
 * @package CubexBase\Application\Applications\Api
 */
class ApiController extends CubexApiController
{

  /**
   * @return Generator|string
   */
  protected function _yieldModules()
  {
    yield new TestModule();
  }
}
