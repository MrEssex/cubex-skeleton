<?php

namespace CubexBase\Application\Layout;

use Cubex\Controller\AuthedController;
use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\Context\Context as CBContext;
use Exception;
use MrEssex\CubexInertiaJsProvider\InertiaResponse;
use Packaged\Context\Context;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\Http\Response;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;
use Packaged\I18n\Translators\Translator;
use Packaged\Ui\Element;
use Packaged\Ui\Html\HtmlElement;
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
   * @throws Exception
   */
  protected function _prepareResponse(Context $c, $result, $buffer = null): Response
  {
    if(!$this->_isAppropriateResponse($result))
    {
      return parent::_prepareResponse($c, $result, $buffer);
    }

    if($c->request()->headers->has('X-Inertia'))
    {
      return InertiaResponse::create($result);
    }

    $theme = new Layout();
    $theme->setContext($this->getContext());
    $theme->pageData = $result;

    return parent::_prepareResponse($c, $theme, $buffer);
  }

  protected function _isAppropriateResponse($result): bool
  {
    return $result instanceof Element || $result instanceof HtmlElement || is_scalar($result) || is_array($result);
  }
}
