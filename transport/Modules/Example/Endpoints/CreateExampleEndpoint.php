<?php
namespace CubexBase\Transport\Modules\Example\Endpoints;

use CubexBase\Transport\Modules\Example\Payloads\CreateExamplePayload;
use CubexBase\Transport\Modules\Example\Responses\ExampleResponse;

class CreateExampleEndpoint extends AbstractExampleEndpoint
{
  public function getVerb(): string
  {
    return self::VERB_POST;
  }

  public function getPayloadClass(): ?string
  {
    return CreateExamplePayload::class;
  }

  public function getResponseClass(): string
  {
    return ExampleResponse::class;
  }
}
