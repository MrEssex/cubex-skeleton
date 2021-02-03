<?php

namespace CubexBase\Application\Applications\Api;

use Cubex\ApiFoundation\Auth\ApiAuthenticator;
use Cubex\ApiFoundation\Controller\ApiController as CubexApiController;
use CubexBase\Application\Applications\Api\Authenticator\Authenticator;
use CubexBase\Application\Applications\Api\Modules\Test\TestModule;
use Generator;
use Packaged\Context\Context;
use Packaged\Context\ContextAware;

/**
 * Class ApiController
 * @package CubexBase\Application\Applications\Api
 */
class ApiController extends CubexApiController
{

  /**
   * @param Context $context
   *
   * @return ApiAuthenticator|Authenticator|mixed|ContextAware
   */
  public function getAuthenticator(Context $context)
  {
    return Authenticator::withContext($context);
  }

  /**
   * @return Generator|string
   */
  protected function _yieldModules()
  {
    yield new TestModule();
  }
}
