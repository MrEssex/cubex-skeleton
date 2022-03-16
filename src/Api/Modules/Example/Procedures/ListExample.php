<?php
namespace CubexBase\Application\Api\Modules\Example\Procedures;

use Cubex\ApiFoundation\Module\Procedures\AbstractProcedure;
use CubexBase\Application\Api\Modules\Example\Storage\Example;
use CubexBase\Transport\Modules\Example\Payloads\ListExamplePayload;
use CubexBase\Transport\Modules\Example\Responses\ExamplesResponse;

class ListExample extends AbstractProcedure
{
  public function execute(ListExamplePayload $pl): ExamplesResponse
  {
    $response = new ExamplesResponse();

    $examples = Example::active();

    /** @var Example $example */
    foreach($examples as $example)
    {
      $response->examples[] = $example->toApiResponse();
    }

    return $response;
  }
}
