<?php

namespace CubexBase\Application\Http\Layout;

use Cubex\Controller\AuthedController;
use Cubex\Cubex;
use Cubex\CubexAware;
use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Http\Middleware\WithMiddlewareTrait;
use CubexBase\Application\Http\Views\Error\ErrorView;
use Packaged\Context\Context;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\Http\Response;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;
use Packaged\I18n\Translators\Translator;
use Packaged\Routing\Handler\Handler;

abstract class WithErrorController extends AuthedController implements WithContext, Translatable, Translator
{
  use GetTranslatorTrait;
  use TranslatableTrait;
  use WithContextTrait;
  use WithMiddlewareTrait;

  protected function _getHandler(Context $context): callable|string|Handler
  {
    $handler = parent::_getHandler($context);
    return $handler ?: 'error';
  }

  protected function _processHandler(Context $c, $handler, &$response): bool
  {
    while(is_callable($handler))
    {
      /** @var Cubex $cubex */
      if($c instanceof CubexAware)
      {
        $cubex = @$c->getCubex();
        $handler = $cubex->resolveMethod($handler[0], $handler[1]);
      }
    }
    return parent::_processHandler($c, $handler, $response);
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
