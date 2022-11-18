<?php
namespace CubexBase\Application\Context\Seo;

use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\Helpers\Strings;
use Packaged\Ui\TemplateLoaderTrait;
use Throwable;

/**
 * Class SeoManager
 * @method title(string $title = null)
 * @method description(string $description = null)
 * @method viewport(string $viewport = null)
 * @method themeColor(string $color = null)
 *
 * @package CubexBase\Application\Context\Seo
 */
class SeoManager implements ContextAware, WithContext
{
  use TemplateLoaderTrait;
  use ContextAwareTrait;
  use WithContextTrait;

  protected array $_values = [];

  public function get(string $name)
  {
    $key = Strings::stringToUnderScore($name);
    return $this->_values[$key] ?? '';
  }

  public function set(string $name, $arguments)
  {
    $key = Strings::stringToUnderScore($name);
    $this->_values[$key] = $arguments[0];
    return $this->_values[$key];
  }

  public function __call(string $name, $arguments)
  {
    return $this->set($name, $arguments);
  }

  public function __get(string $name)
  {
    return $this->get($name);
  }

  public function __set(string $name, string $value)
  {
    $this->set($name, $value);
  }

  public function __isset(string $name)
  {
    $key = Strings::stringToUnderScore($name);
    return isset($this->_values[$key]);
  }

  public function render(): string
  {
    $html = '';
    try
    {
      $html = $this->_renderTemplate();
    }
    catch(Throwable $e)
    {
    }

    return $html;
  }
}
