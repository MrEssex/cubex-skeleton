<?php
namespace CubexBase\Transport\Modules\Example\Payloads;

use Cubex\ApiTransport\Payloads\AbstractPayload;

class CreateExamplePayload extends abstractPayload
{
  public string $title = '';
  public string $description = '';
}
