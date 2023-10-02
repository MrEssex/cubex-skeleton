<?php

namespace CubexBase\Application\Http\Layout;

use CubexBase\Application\Http\Views\AbstractView;
use CubexBase\Application\MainApplication;
use Exception;
use MrEssex\FileCache\Exceptions\InvalidArgumentException;
use Packaged\Context\Context;
use Packaged\Ui\Element;
use Packaged\Ui\Html\HtmlElement;

abstract class LayoutController extends WithErrorController
{
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
}
