<?php
namespace CubexBase\Application\Api\Authenticator;

use Cubex\ApiFoundation\Auth\ApiAuthenticator;
use Cubex\ApiTransport\Permissions\ApiPermission;
use CubexBase\Transport\Modules\Example\Permissions\ExamplePermission;
use Packaged\Context\Conditions\ExpectEnvironment;

class Authenticator extends ApiAuthenticator
{
  public function isAuthenticated(): bool
  {
    return true;
  }

  public function hasPermission(ApiPermission ...$permission)
  {
    foreach($permission as $p)
    {
      if($p instanceof ExamplePermission)
      {
        return $this->getContext()->matches(ExpectEnvironment::local());
      }
    }

    return parent::hasPermission(...$permission);
  }
}
