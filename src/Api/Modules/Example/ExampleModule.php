<?php
namespace CubexBase\Application\Api\Modules\Example;

use Cubex\ApiFoundation\Module\Module;
use Cubex\ApiFoundation\Module\Procedures\ProcedureRoute;
use CubexBase\Application\Api\Modules\Example\Procedures\CreateExample;
use CubexBase\Application\Api\Modules\Example\Procedures\ListExample;
use CubexBase\Transport\Modules\Example\Endpoints\CreateExampleEndpoint;
use CubexBase\Transport\Modules\Example\Endpoints\ListExampleEndpoint;
use Generator;

class ExampleModule extends Module
{
  public function getRoutes(): Generator
  {
    yield new ProcedureRoute(new ListExampleEndpoint(), ListExample::class);
    yield new ProcedureRoute(new CreateExampleEndpoint(), CreateExample::class);
  }

  public static function getBasePath(): string
  {
    return 'example';
  }
}
