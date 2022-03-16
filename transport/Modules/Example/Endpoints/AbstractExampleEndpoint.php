<?php
namespace CubexBase\Transport\Modules\Example\Endpoints;

use Cubex\ApiTransport\Endpoints\AbstractEndpoint;
use CubexBase\Application\Api\Modules\Example\ExampleModule;
use CubexBase\Transport\Modules\Example\Permissions\ExamplePermission;

abstract class AbstractExampleEndpoint extends AbstractEndpoint
{
  public function getPath(): string
  {
    return ExampleModule::getBasePath();
  }

  public function requiresAuthentication(): bool
  {
    return true;
  }

  public function getRequiredPermissions(): array
  {
    return [
      new ExamplePermission(),
    ];
  }
}
