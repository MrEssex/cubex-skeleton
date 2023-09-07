<?php

namespace CubexBase\Application\Cache;

use Packaged\Dal\Cache\CacheDao;
use Packaged\Dal\Exceptions\DataStore\DaoNotFoundException;

abstract class CacheObject extends CacheDao
{
  final protected function __construct(protected string $_cacheKey = "")
  {
    parent::__construct();
    $this->key = $this->_keyPrefix() . $this->_cacheKey;
  }

  protected function _keyPrefix(): string
  {
    return substr(md5(static::class), 0, 10);
  }

  abstract protected function _retrieve();

  public function fetch(): static
  {
    $this->retrieve();
    return $this;
  }

  public function refresh(): static
  {
    $this->data = $this->_retrieve();
    if($this->data !== null)
    {
      $this->save();
    }

    return $this;
  }

  public function retrieve()
  {
    try
    {
      $this->load();
      if($this->data === false || $this->data === null)
      {
        throw new DaoNotFoundException();
      }
    }
    catch(DaoNotFoundException $e)
    {
      $this->refresh();
    }

    return $this->data;
  }
}
