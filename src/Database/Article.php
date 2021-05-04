<?php

namespace CubexBase\Application\Database;

use Cubex\Cache\Apc;
use Exception;
use Packaged\Context\ContextAware;
use Packaged\DalSchema\Databases\Mysql\MySQLColumn;
use Packaged\DalSchema\Databases\Mysql\MySQLColumnType;
use Packaged\DalSchema\Databases\Mysql\MySQLDatabase;
use Packaged\DalSchema\Databases\Mysql\MySQLKey;
use Packaged\DalSchema\Databases\Mysql\MySQLTable;
use Packaged\DalSchema\Table;
use Packaged\Helpers\Objects;
use function glob;

/**
 * Class Article
 *
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

    foreach($articleFiles as $file)
    {
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

  public function getDaoSchema(): Table
  {
    $database = new MySQLDatabase('cubexbase');
    $table = new MySQLTable($database, Objects::classShortname(self::class));

    $table->addColumn(
      new MySQLColumn('id', MySQLColumnType::INT_UNSIGNED(), null, false, null, MySQLColumn::EXTRA_AUTO_INCREMENT),
      new MySQLColumn('title', MySQLColumnType::VARCHAR()),
      new MySQLColumn('content', MySQLColumnType::LONGTEXT()),
      new MySQLColumn('slug', MySQLColumnType::VARCHAR()),
      new MySQLColumn('created', MySQLColumnType::INT_UNSIGNED(), 25, false, 'NOW()'),
      new MySQLColumn('updated', MySQLColumnType::INT_UNSIGNED(), 25, true, null),
      new MySQLColumn('deleted', MySQLColumnType::INT_UNSIGNED(), 25, true, null)
    )->addKey(MySQLKey::PRIMARY('id', 'id'));

    return $table;
  }
}
