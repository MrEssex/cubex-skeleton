<?php
namespace CubexBase\Application\Inertia;

use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;

class Inertia implements ContextAware, WithContext
{
  use ContextAwareTrait;
  use WithContextTrait;

  protected array $_params = [];

  public function getVersion(): string
  {
    return $this->_hashDirectory($this->getContext()->getProjectRoot() . DIRECTORY_SEPARATOR . 'resources');
  }

  /**
   * @param array|string $key
   * @param array|null   $value
   */
  public function share($key, array $value = null): Inertia
  {
    if(is_array($key))
    {
      $this->_params = array_merge($this->_params, $key);
    }
    else
    {
      $this->_params[$key] = $value;
    }

    return $this;
  }

  public function getSharedProps($key = null)
  {
    if(is_string($key) && isset($this->_params[$key]))
    {
      return $this->_params[$key];
    }

    return $this->_params;
  }

  protected function _hashDirectory($directory): string
  {
    $hash = '';
    foreach(scandir($directory) as $file)
    {
      if($file[0] === '.')
      {
        continue;
      }
      $hash .= filemtime($directory . '/' . $file);
    }
    return md5($hash);
  }
}
