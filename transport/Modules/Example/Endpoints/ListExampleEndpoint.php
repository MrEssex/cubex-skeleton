<?php
namespace CubexBase\Transport\Modules\Example\Endpoints;

use CubexBase\Transport\Modules\Example\Payloads\ListExamplePayload;
use CubexBase\Transport\Modules\Example\Responses\ExamplesResponse;

class ListExampleEndpoint extends AbstractExampleEndpoint
{
  public function getVerb(): string
  {
    return self::VERB_GET;
  }

  public function getPayloadClass(): ?string
  {
    return ListExamplePayload::class;
  }

  public function getResponseClass(): string
  {
    return ExamplesResponse::class;
  }
}
