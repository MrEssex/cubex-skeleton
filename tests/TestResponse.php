<?php
namespace CubexBase\Tests;

use Packaged\Http\Response;
use PHPUnit\Framework\Assert;

class TestResponse
{
  /** @var Response */
  protected $_baseResponse;
  protected $_exception;

  public function __construct($response)
  {
    $this->_baseResponse = $response;
  }

  public static function fromBaseResponse($response)
  {
    return new static($response);
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

  public function __get($key)
  {
    return $this->_baseResponse->{$key};
  }
}