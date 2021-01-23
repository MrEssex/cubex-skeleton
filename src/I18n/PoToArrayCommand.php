<?php
namespace CubexBase\Application\I18n;

use Cubex\Console\ConsoleCommand;
use Exception;
use Packaged\Helpers\ValueAs;
use Packaged\I18n\Tools\Gettext\PoFile;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PoToArrayCommand
 * @package CubexBase\Application\I18n
 */
abstract class PoToArrayCommand extends ConsoleCommand
{
  /**
   * @short f
   */
  public $file;
  /**
   * @short o
   */
  public $output;
  /**
   * @short l
   */
  public $lang;

  /**
   * @flag
   */
  public $common;

  /**
   * @return string
   */
  abstract protected function _translationsDir(): string;

  /**
   * @param InputInterface  $input
   * @param OutputInterface $output
   *
   * @throws Exception
   */
  protected function executeCommand(InputInterface $input, OutputInterface $output): void
  {
    $transDir = $this->_translationsDir();

    if(!$this->lang && $this->common)
    {
      $this->lang = AutoTranslate::$common;
    }

    if($this->lang)
    {
      foreach(ValueAs::arr($this->lang) as $lang)
      {
        $this->_processLanguage($transDir . $lang . '.po', $transDir . $lang . '.php');
      }
    }
    else
    {
      $this->_processLanguage($this->file, $this->output);
    }
  }

  /**
   * @param $source
   * @param $output
   *
   * @throws Exception
   */
  protected function _processLanguage($source, $output): void
  {
    if(!file_exists($source))
    {
      throw new Exception("Unable to find $source");
    }

    $po = PoFile::fromString(file_get_contents($source));

    $out = ["<?php", "return ["];
    foreach($po->getTranslations() as $translation)
    {
      foreach($translation->getReferences() as $ref)
      {
        if($translation->getSingularTranslation())
        {
          $out[] = "'" . $ref . "' => ['_' => '"
            . addcslashes(stripslashes($this->_toTranslation($translation->getSingularTranslation())), "'")
            . "'],";
        }
      }
    }
    $out[] = "];";
    $out[] = "";
    file_put_contents($output, implode(PHP_EOL, $out));
  }

  /**
   * @param $str
   *
   * @return string|string[]|null
   */
  protected function _toTranslation($str)
  {
    return preg_replace_callback(
      "/(&#[\d]+;)/",
      function ($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); },
      $str
    );
  }

}
