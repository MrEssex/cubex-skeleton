<?php


namespace CubexBase\Application\Routing;


use Packaged\Context\Context;
use Packaged\Routing\Condition;
use Packaged\Routing\RouteCompleter;

use function file_exists;
use function strtolower;

use const DIRECTORY_SEPARATOR;

/**
 * Class CachedFileRouter
 * @package CubexBase\Application\Routing
 */
class CachedFileRouter implements Condition, RouteCompleter
{
  /** @var string */
  public const RD_FILE = 'cfr.file';

  /** @var string */
  protected string $_directory;
  /** @var string */
  protected string $_locatedFile;

  /**
   * @return static
   */
  public static function i(): CachedFileRouter
  {
    return new static();
  }

  /**
   * @param $dir
   * @return $this
   */
  public function dir($dir): self
  {
    $this->_directory = $dir;
    return $this;
  }

  /**
   * @param Context $context
   * @return bool
   */
  public function match(Context $context): bool
  {
    if ($this->_directory) {
      $checkFile = $context->getProjectRoot() . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $this->_directory
        . DIRECTORY_SEPARATOR . strtolower($context->request()->path()) . '.json';

      if (file_exists($checkFile)) {
        $this->_locatedFile = $checkFile;
        return true;
      }
    }
    return false;
  }

  /**
   * @param Context $context
   */
  public function complete(Context $context): void
  {
    $context->routeData()->set(self::RD_FILE, $this->_locatedFile);
  }

}
