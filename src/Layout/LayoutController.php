<?php

namespace CubexBase\Application\Layout;

use Cubex\Controller\AuthedController;
use Cubex\I18n\GetTranslatorTrait;
use Cubex\Mv\ViewModel;
use CubexBase\Application\Context\AppContext;
use CubexBase\Application\MainApplication;
use CubexBase\Application\Views\AbstractView;
use CubexBase\Application\Views\CachableView;
use Exception;
use MrEssex\FileCache\Exceptions\InvalidArgumentException;
use Packaged\Context\Context;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\Http\Responses\JsonResponse;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;
use Packaged\I18n\Translators\Translator;
use Packaged\Ui\Element;
use Packaged\Ui\Html\HtmlElement;
use PackagedUI\Pagelets\PageletResponse;
use RuntimeException;
use function is_array;
use function is_scalar;

abstract class LayoutController extends AuthedController implements WithContext, Translatable, Translator
{
  use GetTranslatorTrait;
  use TranslatableTrait;
  use WithContextTrait;

  /**
   * @throws Exception
   */
  public function getContext(): Context
  {
    if(parent::getContext() instanceof AppContext)
    {
      return parent::getContext();
    }

    throw new RuntimeException('Invalid Context Passed through');
  }

  /**
   * @throws InvalidArgumentException
   * @throws Exception
   */
  protected function _prepareResponse(Context $c, $result, $buffer = null)
  {
    if($result instanceof PageletResponse && $this->_isPageletRequest($c))
    {
      $result = JsonResponse::create($result);
    }

    if(!$this->_isAppropriateResponse($result))
    {
      return parent::_prepareResponse($c, $result, $buffer);
    }

    $theme = Layout::withContext($this);
    $theme->setContent($result);

    $view = null;
    if($result instanceof ViewModel)
    {
      $view = $result->createView();
      if($view instanceof AbstractView)
      {
        $theme->setHeader($view->getHeader());
        $theme->setFooter($view->getFooter());
        $theme->setPageClass($view->getBlockName() . '-page');
        $theme->setContent($view->render());
      }
    }
    else
    {
      $theme->setContent($result);
    }

    if($view instanceof CachableView && $view->shouldCache())
    {
      $path = $c->request()->getRequestUri();
      $language = $c->request()->getPreferredLanguage();

      MainApplication::$_cache->set($path . $language, $theme->produceSafeHTML());
    }

    return parent::_prepareResponse($c, $theme, $buffer);
  }

  protected function _isAppropriateResponse($result): bool
  {
    return $result instanceof ViewModel || $result instanceof Element ||
      $result instanceof HtmlElement || is_scalar($result) || is_array($result);
  }

  protected function _isPageletRequest(Context $ctx): bool
  {
    return $ctx->request()->headers->has('x-pagelet-request') &&
      $ctx->request()->isXmlHttpRequest();
  }
}
