<?php
namespace CubexBase\Transport\Modules\Example\Responses;

use Cubex\ApiTransport\Responses\AbstractResponse;

class ExamplesResponse extends AbstractResponse
{
  /** @var ExampleResponse[] */
  public array $examples = [];
}
