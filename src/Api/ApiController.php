<?php
namespace CubexBase\Application\Api;

use Cubex\ApiFoundation\Controller\ApiController as CubexApiController;
use CubexBase\Application\Api\Authenticator\Authenticator;
use CubexBase\Application\Api\Modules\Example\ExampleModule;
use Generator;
use Packaged\Context\Context;

class ApiController extends CubexApiController
{
  public const VERSION = '1.0.0';

  protected function _yieldModules(): Generator
  {
    yield new ExampleModule();
  }

  public function getAuthenticator(Context $context)
  {
    return Authenticator::withContext($context);
  }
}
