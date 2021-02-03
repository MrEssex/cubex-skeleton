<?php

namespace CubexBase\ApiTransport\Modules\Test\Endpoints;

use CubexBase\ApiTransport\Modules\Test\Responses\TestResponse;

/**
 * Class TestEndpoint
 * @package CubexBase\ApiTransport\Modules\Test\Endpoints
 */
class TestEndpoint extends AbstractTestEndpoint
{

  /**
   * @return string
   */
  public function getVerb(): string
  {
    return self::VERB_GET;
  }

  /**
   * @return string|null
   */
  public function getPayloadClass(): ?string
  {
    return null;
  }

  /**
   * @return string
   */
  public function getResponseClass(): string
  {
    return TestResponse::class;
  }

}
