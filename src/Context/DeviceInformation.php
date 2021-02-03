<?php

namespace CubexBase\Application\Context;

use DeviceDetector\DeviceDetector;
use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;

/**
 * Class DeviceInformation
 * @package CubexBase\Application\Context
 */
class DeviceInformation implements ContextAware
{
  use ContextAwareTrait;

  /** @var DeviceDetector|null */
  protected ?DeviceDetector $_deviceDetector = null;

  /**
   * DeviceInformation constructor.
   *
   * @param Context $context
   * @param         $userAgent
   */
  public function __construct(Context $context, $userAgent)
  {
    $this->setContext($context);
    if($this->_deviceDetector === null)
    {
      $this->_deviceDetector = new DeviceDetector($userAgent);
    }
  }

  /**
   * @return string
   */
  public function getOs(): string
  {
    return $this->getDeviceDetector()->getOs();
  }

  /**
   * @return DeviceDetector
   */
  public function getDeviceDetector(): DeviceDetector
  {
    $this->_deviceDetector->parse();
    return $this->_deviceDetector;
  }
}
