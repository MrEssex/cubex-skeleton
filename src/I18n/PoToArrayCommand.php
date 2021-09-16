<?php

namespace CubexBase\Application\I18n;

use Cubex\Console\ConsoleCommand;
use Packaged\Helpers\ValueAs;
use Packaged\I18n\Tools\Gettext\PoFile;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class PoToArrayCommand extends ConsoleCommand
{
  /**@short f */
  public $file;
  /**@short o */
  public $output;
  /** @short l */
  public $lang;
  /** @flag */
  public $common;

  protected function executeCommand(InputInterface $input, OutputInterface $output): void
  {
    $transDir = $this->_translationsDir();

    if(!$this->lang && $this->common)
    {
      $this->lang = AutoTranslate::$common;
    }

    $this->_iterateLanguages($transDir);
  }

  abstract protected function _translationsDir(): string;

  /**
   * @param string $transDir
   */
  protected function _iterateLanguages(string $transDir): void
  {
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

  protected function _processLanguage($source, $output): void
  {
    if(!file_exists($source))
    {
      throw new RuntimeException("Unable to find $source");
    }

    $po = PoFile::fromString(file_get_contents($source));

    $out = ["<?php", "return ["];
    if($po)
    {
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
    }
    $out[] = "];";
    $out[] = "";
    file_put_contents($output, implode(PHP_EOL, $out));
  }

  protected function _toTranslation($str)
  {
    return preg_replace_callback(
      "/(&#[\d]+;)/",
      static function ($m) {
        return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES");
      },
      $str
    );
  }
}
