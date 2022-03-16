<?php
namespace CubexBase\Application\Api\Modules\Example\Procedures;

use Cubex\ApiFoundation\Module\Procedures\AbstractProcedure;
use CubexBase\Application\Api\Modules\Example\Storage\Example;
use CubexBase\Transport\Modules\Example\Payloads\CreateExamplePayload;
use CubexBase\Transport\Modules\Example\Responses\ExampleResponse;

class CreateExample extends AbstractProcedure
{
  public function execute(CreateExamplePayload $pl): ExampleResponse
  {
    $example = new Example();
    $example->title = $pl->title;
    $example->description = $pl->description;
    $example->save();

    return $example->toApiResponse();
  }
}
