<?php
namespace CubexBase\Application\Api;

use Cubex\Controller\AuthedController;
use Packaged\Http\Responses\JsonResponse;

class ApiController extends AuthedController
{
  protected function _generateRoutes()
  {
    yield self::_route('articles', 'articles');
  }

  public function postArticles()
  {
    $data = $this->request()->getContent();
    $data = json_decode($data, true);
    $data = $data['article'];

    $newArticle = [
      'title'  => $data['title'],
      'body'   => $data['body'],
      'author' => [
        'name' => "John Doe",
      ],
    ];

    return JsonResponse::create($newArticle);
  }
}
