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
 * @method keywords(string $keywords = null)
 * @method viewport(string $viewport = null)
 * @method themeColor(string $color = null)
 * @method refresh(string $refresh = null)
 * @method generator(string $generator = null)
 * @method referrer(string $referrer = null)
 * @method colorScheme(string $colorScheme = null)
 * @method ogTitle(string $title = null)
 * @method ogDescription(string $description = null)
 * @method ogUrl(string $url = null)
 * @method ogImage(string $image = null)
 * @method ogType(string $type = null)
 * @method ogLocale(string $locale = null)
 * @method twitterSite(string $site = null)
 * @method twitterCreator(string $creator = null)
 *
 * @package CubexBase\Application\Context\Seo
 */
class SeoManager implements ContextAware, WithContext
{
  use TemplateLoaderTrait;
  use ContextAwareTrait;
  use WithContextTrait;

  protected array $_values = [];

  protected array $_meta = [
    'title',
    'description',
    'keywords',
    'author',
    'viewport',
    'theme_color',
    'refresh',
    'generator',
    'referrer',
    'color_scheme',
  ];

  protected array $_ogMeta = [
    'og_title',
    'og_description',
    'og_url',
    'og_image',
    'og_type',
    'og_locale',
  ];

  protected array $_twitterMeta = [
    'twitter_site',
    'twitter_creator',
  ];

  public function get(string $name): string
  {
    $key = Strings::stringToUnderScore($name);
    if(!$this->_isKeyAllowed($key))
    {
      return '';
    }
    return $this->_values[$key] ?? '';
  }

  public function set(string $name, $arguments): string
  {
    $key = Strings::stringToUnderScore($name);
    if(!$this->_isKeyAllowed($key))
    {
      return '';
    }
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
    return $this->_renderTemplate();
  }

  protected function _isKeyAllowed(string $key): bool
  {
    $meta = array_merge($this->_meta, $this->_ogMeta, $this->_twitterMeta);
    return in_array($key, $meta);
  }

  public function getOgMeta(): array
  {
    return $this->_ogMeta;
  }

  public function getTwitterMeta(): array
  {
    return $this->_twitterMeta;
  }

  public function getMeta(): array
  {
    return [
      'theme_color',
      'keywords',
      'author',
      'viewport',
      'refresh',
      'generator',
      'referrer',
      'color_scheme',
    ];
  }
}
