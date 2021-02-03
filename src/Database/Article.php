<?php


namespace CubexBase\Application\Database;

use Cubex\Cache\Apc;
use Exception;
use Packaged\Context\ContextAware;

use function glob;

/**
 * Class Article
 * @package CubexBase\Application\Database
 */
class Article extends AbstractDao
{
  public $id;
  public $title;
  public $content;
  public $slug;
  public $created;
  public $updated;
  public $deleted;

  /**
   * @param ContextAware $ctx
   *
   * @return array
   * @throws Exception
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
