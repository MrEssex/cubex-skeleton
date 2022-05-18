<?php
namespace CubexBase\Application\Context;

use Packaged\Glimpse\Core\CustomHtmlTag;

class SeoMeta
{
  public $title = "Cubex Base";
  public $description = "Example application for Cubex";
  public $keywords = ["cubex", "base", "example"];
  public $robots = "index,follow";
  public $canonical = "";

  public static function create(
    string $title, string $description, array $keywords = [], string $robots = '', string $canonical = ''
  )
  {
    $meta = new self();
    $meta->title = $title;
    $meta->description = $description;
    $meta->keywords = $keywords;
    $meta->robots = $robots;
    $meta->canonical = $canonical;
    return $meta;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function setTitle(string $title)
  {
    $this->title = $title;
    return $this;
  }

  public function getDescription()
  {
    return $this->_createMetaTag('description', $this->description);
  }

  public function setDescription(string $description)
  {
    $this->description = $description;
    return $this;
  }

  public function getKeywords()
  {
    return $this->_createMetaTag('keywords', implode(', ', $this->keywords));
  }

  public function setKeywords(array $keywords)
  {
    $this->keywords = $keywords;
    return $this;
  }

  public function getRobots()
  {
    return $this->_createMetaTag('robots', $this->robots);
  }

  public function setRobots(string $robots)
  {
    $this->robots = $robots;
    return $this;
  }

  public function getCanonical()
  {
    return $this->_createLinkTag('canonical', $this->canonical);
  }

  public function setCanonical(string $canonical)
  {
    $this->canonical = $canonical;
    return $this;
  }

  protected function _createMetaTag(string $name, string $content)
  {
    return CustomHtmlTag::build('meta')
      ->setAttribute('name', $name)
      ->setAttribute('content', $content);
  }

  protected function _createLinkTag(string $rel, string $href)
  {
    return CustomHtmlTag::build('link')
      ->setAttribute('rel', $rel)
      ->setAttribute('href', $href);
  }
}
