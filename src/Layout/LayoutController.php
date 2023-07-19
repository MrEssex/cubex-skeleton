<?php

namespace CubexBase\Application\Layout;

use Cubex\Controller\AuthedController;
use Cubex\I18n\GetTranslatorTrait;
use Cubex\Mv\ViewModel;
use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Views\AbstractView;
use CubexBase\Application\Views\CachableView;
use Exception;
use MrEssex\CubexInertiaJsProvider\InertiaResponse;
use MrEssex\FileCache\Exceptions\InvalidArgumentException;
use Packaged\Context\Context;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
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
   * @throws InvalidArgumentException
   * @throws Exception
   */
  protected function _prepareResponse(Context $c, $result, $buffer = null)
  {
    if(!$this->_isAppropriateResponse($result))
    {
      return parent::_prepareResponse($c, $result, $buffer);
    }

    if($c->request()->headers->has('X-Inertia'))
    {
      return InertiaResponse::create($result);
    }

    $theme = Layout::withContext($this);
    $theme->pageData = $result;

    return parent::_prepareResponse($c, $theme, $buffer);
  }

  protected function _isAppropriateResponse($result): bool
  {
    return $result instanceof ViewModel || $result instanceof Element ||
      $result instanceof HtmlElement || is_scalar($result) || is_array($result);
  }
}
