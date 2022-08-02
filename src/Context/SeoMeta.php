<?php
namespace CubexBase\Application\Context;

use Packaged\Glimpse\Core\CustomHtmlTag;

class SeoMeta
{
  public string $title = "Cubex Base";
  public string $description = "Example application for Cubex";
  public array $keywords = ["Cubex", "base", "example"];
  public string $robots = "index,follow";
  public string $canonical = "";

  public static function create(
    string $title, string $description, array $keywords = [], string $robots = '', string $canonical = ''
  ): SeoMeta
  {
    $meta = new self();
    $meta->title = $title;
    $meta->description = $description;
    $meta->keywords = $keywords;
    $meta->robots = $robots;
    $meta->canonical = $canonical;
    return $meta;
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  public function setTitle(string $title): SeoMeta
  {
    $this->title = $title;
    return $this;
  }

  public function getDescription(): CustomHtmlTag
  {
    return $this->_createMetaTag('description', $this->description);
  }

  public function setDescription(string $description): SeoMeta
  {
    $this->description = $description;
    return $this;
  }

  public function getKeywords(): CustomHtmlTag
  {
    return $this->_createMetaTag('keywords', implode(', ', $this->keywords));
  }

  public function setKeywords(array $keywords): SeoMeta
  {
    $this->keywords = $keywords;
    return $this;
  }

  public function getRobots(): CustomHtmlTag
  {
    return $this->_createMetaTag('robots', $this->robots);
  }

  public function setRobots(string $robots): SeoMeta
  {
    $this->robots = $robots;
    return $this;
  }

  public function getCanonical(): ?CustomHtmlTag
  {
    if($this->canonical === '' || $this->canonical === '0')
    {
      return null;
    }

    return $this->_createLinkTag('canonical', $this->canonical);
  }

  public function setCanonical(string $canonical): SeoMeta
  {
    $this->canonical = $canonical;
    return $this;
  }

  protected function _createMetaTag(string $name, string $content): CustomHtmlTag
  {
    return CustomHtmlTag::build('meta')
      ->setAttribute('name', $name)
      ->setAttribute('content', $content);
  }

  protected function _createLinkTag(string $rel, string $href): CustomHtmlTag
  {
    return CustomHtmlTag::build('link')
      ->setAttribute('rel', $rel)
      ->setAttribute('href', $href);
  }

  public function generateHtml(): string
  {
    $html = [];
    $html[] = $this->getDescription();
    $html[] = $this->getKeywords();
    $html[] = $this->getRobots();
    $html[] = $this->getCanonical();

    return implode("\n", $html);
  }
}
