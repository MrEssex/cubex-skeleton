<?php

namespace CubexBase\Application\Http\Middleware;

use Packaged\Context\Context;
use Symfony\Component\HttpFoundation\Response;

trait WithMiddlewareTrait
{
  /** @var string[] */
  protected $_middleware = [];

  protected function _middleware(): array
  {
    return [];
  }

  public function canProcess(&$response): bool
  {
    foreach($this->_middleware as $middleware)
    {
      $middleware = new $middleware();
      $middleware->setContext($this->getContext());
      $result = $middleware->process($response);

      if($result === false)
      {
        // if the middleware returns false, we should not process the request
        // else we should continue to the next middleware
        return false;
      }
    }

    // Default to true
    return parent::canProcess($response);
  }

  public function handle(Context $c): Response
  {
    $this->_middleware = $this->_middleware();
    return parent::handle($c);
  }
}
