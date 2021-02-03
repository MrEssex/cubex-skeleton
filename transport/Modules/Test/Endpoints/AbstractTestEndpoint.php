<?php

namespace CubexBase\ApiTransport\Modules\Test\Endpoints;

use Cubex\ApiTransport\Endpoints\AbstractEndpoint;
use CubexBase\Application\Applications\Api\Modules\Test\TestModule;

/**
 * Class AbstractTestEndpoint
 * @package CubexBase\ApiTransport\Modules\Test\Endpoints
 */
abstract class AbstractTestEndpoint extends AbstractEndpoint
{

  /**
   * @return string
   */
  public function getPath(): string
  {
    return TestModule::getBasePath();
  }

}
