<?php

namespace CubexBase\Application\Applications\Authentication\Forms\Validators;

use Generator;
use Packaged\Validate\AbstractSerializableValidator;
use Packaged\Validate\SerializableValidator;

/**
 * Class UserExistsValidator
 * @package CubexBase\Application\Applications\Authentication\Forms\Validators
 */
class UserExistsValidator extends AbstractSerializableValidator
{

  /**
   * @param $value
   *
   * @return Generator
   */
  protected function _doValidate($value): Generator
  {
    if ($value !== '1') {
      yield $this->_makeError('Account doesnt exist');
    }
  }

  /**
   * @param $configuration
   *
   * @return SerializableValidator
   */
  public static function deserialize($configuration): SerializableValidator
  {
    return new static();
  }

  /**
   * @return array
   */
  public function serialize(): array
  {
    return [];
  }
}
