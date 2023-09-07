<?php

namespace CubexBase\Application\Context\Providers;

use Packaged\Context\Context;
use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;

abstract class AbstractProvider implements ContextAware, WithContext
{
  use ContextAwareTrait;
  use WithContextTrait;

  protected static ?self $_instance = null;

  /**
   * AbstractProvider constructor.
   */
  private function __construct() { }

  /**
   * Returns an instance of the provider
   *
   * @param Context $context
   *
   * @return static
   */
  public static function instance(Context $context): static
  {
    if(!static::$_instance instanceof static)
    {
      static::$_instance = static::withContext($context);
    }

    return static::$_instance;
  }
}