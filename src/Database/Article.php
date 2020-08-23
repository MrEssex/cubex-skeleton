<?php


namespace CubexBase\Application\Database;

use Cubex\Cache\Apc;
use DateTime;
use Packaged\Context\ContextAware;

use function glob;

/**
 * Class Article
 * @package CubexBase\Application\Database
 */
class Article extends AbstractDao
{
  public int $id;
  public string $title;
  public string $content;
  public string $slug;
  public string $metaTitle;
  public string $metaDescription;
  public int $active;
  public string $thumbnailPath;
  public DateTime $displayDate;
  public DateTime $created;
  public DateTime $updated;
  public DateTime $deleted;

  /**
   * @param ContextAware $ctx
   * @return array
   */
  public static function allCached(ContextAware $ctx): array
  {
    $articles = [];
    $articleFiles = Apc::retrieve(
      'article-files',
      static function () use ($ctx) {
        return glob($ctx->getContext()->getProjectRoot() . '/data/articles/*.json');
      },
      60
    );

    foreach ($articleFiles as $file) {
      $articles[] = Apc::retrieve(
        "article-" . $file,
        static function () use ($file) {
          return static::fromJson($file);
        },
        60
      );
    }
    return $articles;
  }
}