<?php

namespace CubexBase\Application\Applications\Api\Authenticator;

use Cubex\ApiFoundation\Auth\ApiAuthenticator;
use Cubex\ApiTransport\Permissions\ApiPermission;

/**
 * Class Authenticator
 * @package CubexBase\Application\Applications\Api\Authenticator
 */
class Authenticator extends ApiAuthenticator
{

  /**
   * @return bool
   */
  public function isAuthenticated(): bool
  {
    return true;
  }

  /**
   * @param ApiPermission ...$permission
   *
   * @return bool
   */
  public function hasPermission(ApiPermission ...$permission): bool
  {
    return true;
  }

}
