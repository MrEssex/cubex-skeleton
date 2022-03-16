<?php
namespace CubexBase\Transport\Responses;

use Cubex\ApiTransport\Responses\AbstractResponse;

class ApplicationResponse extends AbstractResponse
{
  public int $id = 0;
  public bool $active = true;
  public string $created_at = '';
  public ?string $updated_at;
  public ?string $deleted_at;
}
