<?php


namespace FusionBase\Application\Database;


use Exception;
use Packaged\Dal\Ql\QlDao;
use Packaged\Helpers\Objects;
use Packaged\Helpers\Strings;

use function file_get_contents;
use function json_decode;

/**
 * Class AbstractDao
 * @package FusionBase\Application\Database
 */
class AbstractDao extends QlDao
{
  /** @var string */
  protected $_dataStoreName = 'fusion_sql';

  /**
   * AbstractDao constructor.
   * @param bool $forStaticUse
   */
  public function __construct($forStaticUse = false)
  {
    if (!$forStaticUse) {
      parent::__construct();
    }
  }

  /**
   * @param $path
   *
   * @return object
   * @throws Exception
   */
  public static function fromJson($path)
  {
    return Objects::hydrate(new static(true), json_decode(file_get_contents($path)));
  }

  /**
   * @param $path
   * @return array
   * @throws Exception
   */
  public static function collectionFromJson($path): array
  {
    $entries = json_decode(file_get_contents($path));
    $result = [];
    foreach ($entries as $k => $entry) {
      $result[$k] = Objects::hydrate(new static(), $entry);
    }
    return $result;
  }

  /**
   * @return mixed|string
   */
  public function getTableName()
  {
    return Strings::stringToUnderScore(Strings::splitOnCamelCase(Objects::classShortname($this)));
  }
}