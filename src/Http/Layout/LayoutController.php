<?php

namespace CubexBase\Application\Http\Layout;

use Cubex\Controller\AuthedController;
use Cubex\I18n\GetTranslatorTrait;
use Cubex\Middleware\MiddlewareHandler;
use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Http\Layout\DefaultLayout\DefaultLayout;
use CubexBase\Application\Http\Views\AbstractView;
use CubexBase\Application\Http\Views\Error\ErrorView;
use CubexBase\Application\MainApplication;
use Packaged\Context\Context;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;
use Packaged\I18n\Translators\Translator;
use Packaged\Routing\Handler\FuncHandler;
use Packaged\Routing\Handler\Handler;
use Packaged\Ui\Element;
use Packaged\Ui\Html\HtmlElement;
use Symfony\Component\HttpFoundation\Response;

abstract class LayoutController extends AuthedController implements WithContext, Translatable, Translator
{
  use TranslatableTrait;
  use WithContextTrait;
  use GetTranslatorTrait
  {
    GetTranslatorTrait::_getTranslator insteadof TranslatableTrait;
  }

  protected function _prepareResponse(Context $c, $result, $buffer = null)
  {
    // Send the raw response if it's an ajax request or not appropriate for the layout
    if(!$this->_isAppropriateResponse($result) || $this->_isAjaxResponse($result))
    {
      return parent::_prepareResponse($c, $result, $buffer);
    }

    $theme = $this->getTheme();
    $theme->setContent($result);

    if($result instanceof AbstractView)
    {
      $theme->setHeader($result->getHeader());
      $theme->setFooter($result->getFooter());
      $theme->setPageClass($result->getBlockName() . '-page');

      if($result->shouldCache())
      {
        $path = $c->request()->getRequestUri();
        $language = $c->request()->getPreferredLanguage();

        MainApplication::$_cache->set($path . $language, $theme->produceSafeHTML());
      }

      if(!$result->shouldIndex())
      {
        $c->meta()->set('no-index', true);
      }
    }

    return parent::_prepareResponse($c, $theme, $buffer);
  }

  public function getTheme()
  {
    $cubex = @$this->_cubex();
    return $cubex->resolve(DefaultLayout::class);
  }

  public function processError(AppContext $ctx): ErrorView
  {
    return ErrorView::withContext($this);
  }

  public function handle(Context $c): Response
  {
    $middleware = new MiddlewareHandler(new FuncHandler(fn(Context $c) => parent::handle($c)));

    foreach($this->_middleware() as $m)
    {
      $middleware->add($m);
    }

    return $middleware->handle($c);
  }

  protected function _middleware(): array
  {
    return [];
  }

  protected function _isAppropriateResponse($result): bool
  {
    return $result instanceof Element || $result instanceof HtmlElement || is_scalar($result) || is_array($result);
  }

  protected function _isAjaxResponse(mixed $result): bool
  {
    $c = $this->getContext();
    return (is_scalar($result) || is_array($result)) && $c->request()->isXmlHttpRequest();
  }

  protected function _getHandler(Context $context): callable|string|Handler
  {
    return parent::_getHandler($context) ?: 'error';
  }
}
