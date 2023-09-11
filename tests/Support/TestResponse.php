<?php
namespace CubexBase\Tests\Support;

use Packaged\Http\Response;
use PHPUnit\Framework\Assert;
use ReflectionClass;

class TestResponse
{
  protected Response $_baseResponse;
  protected $_exception;

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

  public function __get($key)
  {
    $class = new ReflectionClass($this->_baseResponse);
    $property = $class->getProperty($key);
    $property->setAccessible(true);
    return $property->getValue($this->_baseResponse);
  }

  public function __set(string $name, $value): void
  {
    $class = new ReflectionClass($this->_baseResponse);
    $property = $class->getProperty($name);
    $property->setAccessible(true);
    $property->setValue($this->_baseResponse, $value);
  }

  public function __isset(string $name): bool
  {
    return isset($this->_baseResponse->{$name});
  }
}
