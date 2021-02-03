<?php

namespace CubexBase\Application\Applications\Api\Modules\Test;

use Cubex\ApiFoundation\Module\Module;
use Cubex\ApiFoundation\Module\Procedures\ProcedureRoute;
use CubexBase\ApiTransport\Modules\Test\Endpoints\TestEndpoint;
use CubexBase\Application\Applications\Api\Modules\Test\Procedures\InitTest;
use Generator;

/**
 * Class TestModule
 * @package CubexBase\Application\Applications\Api\Modules\Test
 */
class TestModule extends Module
{

  /**
   * @return Generator
   */
  public function getRoutes(): Generator
  {
    yield new ProcedureRoute(new TestEndpoint(), InitTest::class);
  }

  /**
   * @return string
   */
  public static function getBasePath(): string
  {
    return 'test';
  }
}
