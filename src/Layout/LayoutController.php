<?php

namespace CubexBase\Application\Layout;

use Cubex\Controller\AuthedController;
use Cubex\I18n\GetTranslatorTrait;
use Cubex\Mv\ViewModel;
use CubexBase\Application\Context\Context as CBContext;
use CubexBase\Application\MainApplication;
use CubexBase\Application\Pages\AbstractView;
use CubexBase\Application\Pages\ViewClass;
use Exception;
use MrEssex\FileCache\Exceptions\InvalidArgumentException;
use Packaged\Context\Context;
use Packaged\Context\Context as PackagedContext;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\Http\Response;
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

  protected function _generateRoutes(): string
  {
    return '';
  }

  /**
   * @throws Exception
   */
  public function getContext(): PackagedContext
  {
    if(parent::getContext() instanceof CBContext)
    {
      return parent::getContext();
    }

    throw new RuntimeException('Invalid Context Passed through');
  }

  /**
   * @throws InvalidArgumentException
   * @throws Exception
   */
  protected function _prepareResponse(Context $c, $result, $buffer = null): Response
  {
    if($result instanceof ViewModel)
    {
      $result = $result->createView();
    }

    if(!$this->_isAppropriateResponse($result))
    {
      return parent::_prepareResponse($c, $result, $buffer);
    }

    $theme = new Layout();

    if($result instanceof PageletResponse)
    {
      $result = JsonResponse::create($result);
    }

    $theme->setContext($this->getContext())->setContent($result);

    if($result instanceof ViewClass)
    {
      $theme->setPageClass($result->getPageClass());
    }

    if($result instanceof AbstractView && $result->shouldCache())
    {
      $path = $c->request()->getRequestUri();
      $language = $c->request()->getPreferredLanguage();

      MainApplication::$_cache->set($path . $language, $theme->produceSafeHTML());
    }

    return parent::_prepareResponse($c, $theme, $buffer);
  }

  protected function _isAppropriateResponse($result): bool
  {
    return $result instanceof Element || $result instanceof HtmlElement || is_scalar($result) || is_array($result);
  }
}
