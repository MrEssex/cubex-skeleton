<?php
namespace CubexBase\Tests\Support;

use Packaged\Http\Response;
use PHPUnit\Framework\Assert;

class TestResponse
{
  protected Response $_baseResponse;

  final public function __construct($response)
  {
    $this->_baseResponse = $response;
  }

  public static function fromBaseResponse($response)
  {
    return new self($response);
  }

  public function assertStatus($status)
  {
    $actual = $this->_baseResponse->getStatusCode();

    Assert::assertSame(
      $actual,
      $status,
      "Expected status code {$status}, got {$actual}"
    );

    return $this;
  }

  public function getContent()
  {
    return $this->_baseResponse->getContent();
  }
}
