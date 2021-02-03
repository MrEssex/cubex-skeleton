<?php

namespace CubexBase\Application\Applications\Api\Modules\Test\Procedures;

use CubexBase\ApiTransport\Modules\Test\Responses\TestResponse;

/**
 * Class InitTest
 * @package CubexBase\Application\Applications\Api\Modules\Test\Procedures
 */
class InitTest extends AbstractTestProcedure
{

  /**
   * @return TestResponse
   */
  public function execute(): TestResponse
  {
    $response = new TestResponse();
    $response->testString = "Hello World";

    return $response;
  }

}
