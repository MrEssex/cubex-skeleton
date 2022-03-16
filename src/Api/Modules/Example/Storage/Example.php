<?php
namespace CubexBase\Application\Api\Modules\Example\Storage;

use CubexBase\Application\Api\Storage\AbstractStorage;
use CubexBase\Transport\Modules\Example\Responses\ExampleResponse;

class Example extends AbstractStorage
{
  public string $title = '';
  public ?string $description;

  protected function _getResponse(): ExampleResponse
  {
    return new ExampleResponse();
  }
}
