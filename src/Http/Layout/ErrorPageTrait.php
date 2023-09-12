<?php

namespace CubexBase\Application\Http\Layout;

use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Http\Views\Error\ErrorView;
use Packaged\Context\Context;
use Packaged\Http\Response;
use Packaged\Routing\Handler\Handler;

trait ErrorPageTrait
{
  protected function _getHandler(Context $context): callable|string|Handler
  {
    $handler = parent::_getHandler($context);
    return $handler ?: 'error';
  }

  protected function _makeCubexResponse($content): Response
  {
    $result = parent::_makeCubexResponse($content);
    $meta = $this->getContext()->meta();
    if($meta->has('status-code'))
    {
      $result->setStatusCode($meta->get('status-code'));
    }
    return $result;
  }

  public function processError(AppContext $ctx)
  {
    $ctx->meta()->set('status-code', 404);
    return ErrorView::withContext($this);
  }
}
