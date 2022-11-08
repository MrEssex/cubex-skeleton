<?php
namespace CubexBase\Tests;

use Cubex\Cubex;
use CubexBase\Application\Context\AppContext;
use CubexBase\Application\MainApplication;
use JsonException;
use Packaged\Context\Context;
use Packaged\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TestCase extends \PHPUnit\Framework\TestCase
{
  protected array $_headers = [];

  /**
   * @return void
   */
  public function setUp(): void
  {
    parent::setUp();
  }

  /**
   * @param string $uri
   * @param array  $data
   * @param array  $headers
   *
   * @return TestResponse
   * @throws JsonException
   * @throws Throwable
   */
  public function postJson(string $uri, array $data = [], array $headers = []): TestResponse
  {
    return $this->json('POST', $uri, $data, $headers);
  }

  /**
   * @param string $method
   * @param string $uri
   * @param array  $data
   * @param array  $headers
   *
   * @return TestResponse
   * @throws JsonException
   * @throws Throwable
   */
  public function json(string $method, string $uri, array $data = [], array $headers = []): TestResponse
  {
    $content = json_encode($data, JSON_THROW_ON_ERROR);
    $headers = array_merge($this->_headers, $headers);
    return $this->call(
      $method,
      $uri,
      [],
      [],
      [],
      $headers,
      $content
    );
  }

  /**
   * @param string      $method
   * @param string      $uri
   * @param array       $parameters
   * @param array       $cookies
   * @param array       $files
   * @param array       $server
   * @param string|null $content
   *
   * @return TestResponse
   * @throws Throwable
   */
  public function call(
    string $method, string $uri, array $parameters = [], array $cookies = [], array $files = [], array $server = [],
    string $content = null
  ): TestResponse
  {
    $projectRoot = dirname(__DIR__);
    $loader = require($projectRoot . '/vendor/autoload.php');
    $request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);

    $customContext = new AppContext($request);
    $cubex = new Cubex($projectRoot, $loader);
    $cubex->prepareContext($customContext);
    $cubex->share(Context::class, $customContext);
    $response = $cubex->handle(new MainApplication($cubex));
    $cubex->shutdown(false);

    return $this->_createTestResponse($response);
  }

  protected function _createTestResponse(Response $response): TestResponse
  {
    return TestResponse::fromBaseResponse($response);
  }
}
