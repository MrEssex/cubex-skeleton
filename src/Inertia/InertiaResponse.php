<?php
namespace CubexBase\Application\Inertia;

use Packaged\Http\Responses\JsonResponse;

class InertiaResponse
{
  public static function create($result)
  {
    return JsonResponse::create(
      $result,
      200,
      ['content-type' => 'application/json', 'X-Inertia' => 'true', 'Vary' => 'Accept']
    );
  }
}
