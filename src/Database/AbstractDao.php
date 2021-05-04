<?php

namespace CubexBase\Application\Database;

use Exception;
use Packaged\Dal\Ql\QlDao;
use Packaged\DalSchema\DalSchemaProvider;
use Packaged\Helpers\Objects;
use Packaged\Helpers\Strings;
use function file_get_contents;
use function json_decode;

/**
 * Class AbstractDao
 *
 * @package CubexBase\Application\Database
 */
abstract class AbstractDao extends QlDao implements DalSchemaProvider
{
  /** @var string */
  protected $_dataStoreName = 'cubex_sql';

  /**
   * AbstractDao constructor.
   *
   * @param bool $forStaticUse
   */
  public function __construct($forStaticUse = false)
  {
    if(!$forStaticUse)
    {
      parent::__construct();
    }
  }

  /**
   * @param $path
   *
   * @return object
   * @throws Exception
   */
  public static function fromJson($path): object
  {
    return Objects::hydrate(new static(true), json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR));
  }

  /**
   * @param $path
   *
   * @return array
   * @throws Exception
   */
  public static function collectionFromJson($path): array
  {
    $entries = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
    $result = [];
    foreach($entries as $k => $entry)
    {
      $result[$k] = Objects::hydrate(new static(), $entry);
    }
    return $result;
  }

  /**
   * @return string
   */
  public function getTableName(): string
  {
    return Strings::stringToUnderScore(Strings::splitOnCamelCase(Objects::classShortname($this)));
  }
}
