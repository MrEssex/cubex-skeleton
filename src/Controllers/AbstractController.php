<?php

namespace CubexBase\Application\Controllers;

use Cubex\Controller\AuthedController;
use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\Context\Context as CBContext;
use CubexBase\Application\Layout\Layout;
use CubexBase\Application\MainApplication;
use CubexBase\Application\Pages\AbstractPage;
use CubexBase\Application\Pages\PageClass;
use Packaged\Context\Context;
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
use Psr\SimpleCache\InvalidArgumentException;
use function is_array;
use function is_scalar;

/**
 * @method CBContext getContext() : Context
 */
abstract class AbstractController extends AuthedController implements WithContext, Translatable, Translator
{
  use GetTranslatorTrait;
  use TranslatableTrait;
  use WithContextTrait;

  protected function _generateRoutes()
  {
    return '';
  }

  /**
   * @throws InvalidArgumentException
   */
  protected function _prepareResponse(Context $c, $result, $buffer = null): Response
  {
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

    if($result instanceof PageClass)
    {
      $theme->setPageClass($result->getPageClass());
    }

    if($result instanceof AbstractPage && $result->shouldCache())
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