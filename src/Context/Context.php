<?php

namespace CubexBase\Application\Context;

use Packaged\Config\Provider\Ini\IniConfigProvider;
use Packaged\Dal\DalResolver;
use Packaged\Http\LinkBuilder\LinkBuilder;
use Packaged\Rwd\Country\CountryCode;
use Packaged\Rwd\Country\CountryHelper;
use Packaged\Rwd\Country\CountryInterface;

/**
 * Class Context
 * @package CubexBase\Application
 */
class Context extends \Cubex\Context\Context
{

  /** @var CountryInterface */
  protected CountryInterface $_country;

  /** @var IpInformation|null */
  protected ?IpInformation $_ipInfo = null;

  /** @var DeviceInformation|null */
  protected ?DeviceInformation $deviceInformation = null;

  /**
   * CliContext Constructor.
   */
  protected function _construct(): void
  {
    parent::_construct();
    (new DalResolver(
      new IniConfigProvider($this->getProjectRoot() . '/conf/connections.ini'),
      new IniConfigProvider($this->getProjectRoot() . '/conf/datastores.ini')
    ))->boot();
  }

  /**
   * @param string $path
   * @param array  $query
   *
   * @return LinkBuilder
   */
  public function linkBuilder($path = '', $query = []): LinkBuilder
  {
    return LinkBuilder::fromRequest($this->request(), $path, $query);
  }

  /**
   * @return IpInformation
   */
  public function ip(): IpInformation
  {
    if($this->_ipInfo === null)
    {
      $this->_ipInfo = new IpInformation($this, $this->request()->getClientIp());
    }
    return $this->_ipInfo;
  }

  /**
   * @return CountryInterface
   */
  public function country(): CountryInterface
  {
    if($this->_country === null)
    {
      $this->_country = CountryHelper::getCountry($this->ip()->getCountry(), CountryCode::CODE_US);
    }
    return $this->_country;
  }

  public function deviceInformation(): DeviceInformation
  {
    if($this->deviceInformation === null)
    {
      $this->deviceInformation = new DeviceInformation($this, $this->getContext()->request()->userAgent());
    }

    return $this->deviceInformation;
  }

  /**
   * @return string
   */
  public function getSessionSecret(): string
  {
    return ' jkn2iu3hrb@£$@rfv23£Q@fv';
  }

}
