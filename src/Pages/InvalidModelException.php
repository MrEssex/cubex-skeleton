<?php
namespace CubexBase\Application\Pages;

use Cubex\Mv\Model;
use RuntimeException;

class InvalidModelException extends RuntimeException
{
  public function __construct(Model $object, $expected, $code = 0)
  {
    $message = "Invalid model type '" . get_class($object) . "' received, expected '" . get_class($expected) . "'";
    parent::__construct($message, $code);
  }
}
