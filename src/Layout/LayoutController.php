<?php

namespace CubexBase\Application\Layout;

use Cubex\Controller\AuthedController;
use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\Context\AppContext;
use CubexBase\Application\MainApplication;
use CubexBase\Application\Pages\CachablePage;
use CubexBase\Application\Pages\PageClass;
use Exception;
use MrEssex\FileCache\Exceptions\InvalidArgumentException;
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

    if($result instanceof CachablePage && $result->shouldCache())
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
