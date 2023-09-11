<?php

namespace CubexBase\Application\Http\Layout;

use Cubex\Controller\AuthedController;
use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\Context\AppContext;
use CubexBase\Application\Http\Views\AbstractView;
use CubexBase\Application\Http\Views\Error\ErrorView;
use CubexBase\Application\MainApplication;
use Exception;
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

    // Send the raw response if it's an ajax request
    if($c->request()->isXmlHttpRequest())
    {
      if(is_scalar($result) || is_array($result))
      {
        return parent::_prepareResponse($c, $result, $buffer);
      }
    }

    $theme = Layout::withContext($this);
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

  protected function _isAppropriateResponse($result): bool
  {
    return $result instanceof Element || $result instanceof HtmlElement || is_scalar($result) || is_array($result);
  }

  protected function _makeCubexResponse($content)
  {
    $result = parent::_makeCubexResponse($content);
    $meta = $this->getContext()->meta();
    if($meta->has('status-code'))
    {
      $result->setStatusCode($meta->get('status-code'));
    }
    return $result;
  }

  protected function _getHandler(Context $context)
  {
    $handler = parent::_getHandler($context);
    return $handler ?: 'error'; // If no handler default to error (processError)
  }

  public function processError(AppContext $ctx)
  {
    $ctx->meta()->set('status-code', 404);
    return ErrorView::withContext($this);
  }
}
