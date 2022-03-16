<?php
namespace CubexBase\Transport\Responses;

use Cubex\ApiTransport\Responses\AbstractResponse;

class ApplicationResponse extends AbstractResponse
{
  public $id;
  public $active;
  public $created_at;
  public $updated_at;
  public $deleted_at;
}
