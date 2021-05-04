<?php

namespace CubexBase\Application\Layout;

use Cubex\Controller\AuthedController;
use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\Context\Context as CBContext;
use CubexBase\Application\MainApplication;
use CubexBase\Application\Pages\AbstractPage;
use CubexBase\Application\Pages\PageClass;
use Generator;
use Packaged\Context\Context;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\Http\Response;
use Packaged\Http\Responses\JsonResponse;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;
use Packaged\I18n\Translators\Translator;
use Packaged\Routing\Handler\Handler;
use Packaged\Routing\HealthCheckCondition;
use Packaged\Routing\Route;
use Packaged\Ui\Element;
use Packaged\Ui\Html\HtmlElement;
use PackagedUI\Pagelets\PageletResponse;
use Psr\SimpleCache\InvalidArgumentException;
use function is_array;
use function is_scalar;

/**
 * Class AbstractController
 * @package CubexBase\Application\Controller
 * @method CBContext getContext() : Context
 */
abstract class LayoutController extends AuthedController implements WithContext, Translatable, Translator
{

  use GetTranslatorTrait;
  use TranslatableTrait;
  use WithContextTrait;

  /**
   * @return callable|Generator|Handler|Route[]|string
   */
  protected function _generateRoutes()
  {
    yield self::_route('hc', HealthCheckCondition::i());
    return '';
  }

  /**
   * @param Context $c
   * @param mixed $result
   * @param null $buffer
   *
   * @return mixed|Response
   * @throws InvalidArgumentException
   */
  protected function _prepareResponse(Context $c, $result, $buffer = null): Response
  {
    if (($result instanceof Element || $result instanceof HtmlElement || is_scalar($result) || is_array($result))) {
      $theme = new Layout();

      if ($result instanceof PageletResponse) {
        $result = JsonResponse::create($result);
      }

      if ($result instanceof PageClass) {
        $theme->setPageClass($result->getPageClass());
      }

      $path = $c->request()->getRequestUri();
      $language = $c->request()->getPreferredLanguage();

      $theme->setContext($this->getContext())->setContent($result);

      if ($result instanceof AbstractPage && $result->shouldCache()) {
        MainApplication::$_cache->set($path . $language, $theme->produceSafeHTML(), MainApplication::FILE_CACHE_TTL);
      }

      return parent::_prepareResponse($c, $theme, $buffer);
    }

    return parent::_prepareResponse($c, $result, $buffer);
  }

}
