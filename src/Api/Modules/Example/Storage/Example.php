<?php
namespace CubexBase\Application\Api\Modules\Example\Storage;

use CubexBase\Application\Api\Storage\AbstractStorage;
use CubexBase\Transport\Modules\Example\Responses\ExampleResponse;

class Example extends AbstractStorage
{
  public string $title = '';
  public ?string $description;

  public function toApiResponse()
  {
    $r = $this->_getResponse();

    $r->title = $this->title;
    $r->description = $this->description;

    return parent::toApiResponse();
  }

  protected function _getResponse(): ExampleResponse
  {
    if($this->_response === null)
    {
      $this->_response = new ExampleResponse();
    }

    return $this->_response;
  }
}
