<?php

namespace CubexBase\Application\Context\Providers;

use Packaged\Context\Context;
use Packaged\Glimpse\Core\CustomHtmlTag;

/**
 * @method static SeoProvider instance(Context $context)
 */
class SeoProvider extends AbstractProvider
{
  protected array $tags = [];
  protected array $twitterTags = [];
  protected array $openGraphTags = [];

  protected string $title = '';

  public function setTitle(string $title): static
  {
    $this->title = $title;
    return $this;
  }

  public function meta(string $name, string $value)
  {
    $this->_push('meta', ['name' => $name, 'content' => $value]);
    return $this;
  }

  public function og(string $name, string $value)
  {
    $this->openGraphTags[] = [
      'meta',
      [
        'property' => 'og:' . $name,
        'content'  => $value,
      ],
    ];
    return $this;
  }

  public function twitter(string $name, string $value)
  {
    $this->twitterTags[] = [
      'meta',
      [
        'property' => 'twitter:' . $name,
        'content'  => $value,
      ],
    ];
    return $this;
  }

  protected function _push(string $name, array $attrs)
  {
    foreach($attrs as $k => $v)
    {
      $attrs[$k] = $v;
    }

    $this->tags[] = [$name, $attrs];
    return $this;
  }

  protected function _build(array $tags)
  {
    $out = '';
    foreach($tags as $tag)
    {
      $attrs = [];
      foreach($tag[1] as $k => $v)
      {
        $attrs[$k] = $v;
      }
      $out .= CustomHtmlTag::build($tag['0'], $attrs, '');
    }

    return $out;
  }

  public function __toString(): string
  {
    // Default Site Title
    if(empty($this->title))
    {
      $config = $this->getContext()->config()->getSection('site');
      $this->title = $config->getItem('title', 'Default Site Title');
      $this->og('title', $this->title);
    }

    $title = CustomHtmlTag::build('title', [], $this->title);
    return $title . $this->_build($this->tags) .
      $this->_build($this->twitterTags) .
      $this->_build($this->openGraphTags);
  }
}
