<?php

namespace CubexBase\Application\Context;

use Cubex\Cache\Apc;
use Exception;
use GeoIp2\Database\Reader;
use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Helpers\Path;
use Packaged\Http\Request;

/**
 * Class IPInformation
 * @package CubexBase\Application\Context
 */
class IpInformation implements ContextAware
{
  use ContextAwareTrait;

  /** @var string|null */
  protected ?string $_ip = "";

  /** @var Reader|null */
  private ?Reader $_maxmind = null;

  /** @var mixed */
  protected $_ipData;

  /**
   * IPInformation constructor.
   *
   * @param Context     $context
   * @param string|null $ip
   */
  public function __construct(Context $context, string $ip = null)
  {
    $this->setContext($context);

    if($ip !== null)
    {
      if(Request::isPrivateIP($ip))
      {
        $this->_ip = '185.35.50.4';
      }
      else
      {
        $this->_ip = $ip;
      }
    }
  }

  /**
   * @return Reader|null
   */
  protected function _getMaxmind(): ?Reader
  {
    if($this->_maxmind === null)
    {
      try
      {
        $root = $this->getContext()->getProjectRoot();
        $paths = [
          Path::system($root, 'resources', 'GeoIP2-City.mmdb'),
        ];
        foreach($paths as $path)
        {
          if(file_exists($path))
          {
            $this->_maxmind = new Reader($path);
            break;
          }
        }
      }
      catch(Exception $e)
      {
        $this->_maxmind = null;
      }
    }
    return $this->_maxmind === false ? null : $this->_maxmind;
  }

  /**
   * @return mixed
   */
  protected function _getIpData()
  {
    if($this->_ipData === null)
    {
      try
      {
        $this->_ipData = Apc::retrieve(
          "ipcity-" . $this->_ip,
          function () { return $this->_getMaxmind()->city($this->_ip); }
        );
      }
      catch(Exception $e)
      {
        //Unsupported country
      }
    }
    return $this->_ipData;
  }

  /**
   * @return object
   */
  public function getIpData(): object
  {
    $this->_getIpData();
    return $this->_ipData;
  }

  /**
   * @return mixed
   */
  public function getCountry()
  {
    $this->_getIpData();
    return $this->_ipData->country();
  }
}
