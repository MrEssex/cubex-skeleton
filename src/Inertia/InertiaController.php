<?php
namespace CubexBase\Application\Inertia;

use Exception;
use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use RuntimeException;

class InertiaController implements ContextAware, WithContext
{
  use ContextAwareTrait;
  use WithContextTrait;

  /**
   * @throws Exception
   */
  public function getContext(): \CubexBase\Application\Context\Context
  {
    if($this->_context instanceof \CubexBase\Application\Context\Context)
    {
      return $this->_context;
    }

    throw new RuntimeException("Context must be an instance of CubexBade Context");
  }

  public function inertia(string $component, array $params = [])
  {
    return [
      'component' => $component,
      'props'     => $this->_getInertiaProps($params),
      'url'       => $this->_getInertiaUrl(),
      'version'   => $this->_getInertiaVersion(),
    ];
  }

  /**
   * @throws Exception
   */
  protected function _getInertiaProps(array $params): array
  {
    return array_merge($this->getContext()->inertia()->getSharedProps(), $params);
  }

  /**
   * @throws Exception
   */
  protected function _getInertiaUrl(): string
  {
    return $this->getContext()->request()->url();
  }

  /**
   * @throws Exception
   */
  protected function _getInertiaVersion()
  {
    return $this->getContext()->inertia()->getVersion();
  }
}
