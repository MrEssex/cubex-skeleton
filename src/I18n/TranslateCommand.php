<?php
namespace CubexBase\Application\I18n;

use Cubex\Console\ConsoleCommand;
use Packaged\Helpers\ValueAs;
use Packaged\I18n\Catalog\DynamicArrayCatalog;
use Packaged\I18n\Catalog\Message;
use Packaged\I18n\Tools\Gettext\PoFile;
use Packaged\I18n\Tools\Gettext\PoTranslation;
use Packaged\Rwd\Language\LanguageCode;

abstract class TranslateCommand extends ConsoleCommand
{
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
   * Process
   */
  public function process(): void
  {
    $transDir = $this->_translationsDir();

    if(!$this->lang && $this->common)
    {
      $this->lang = AutoTranslate::$common;
    }

    foreach(ValueAs::arr($this->lang) as $lang)
    {
      $poLoc = $transDir . $lang . '.po';

      $poEdit = file_exists($poLoc) ? PoFile::fromString(file_get_contents($poLoc)) : new PoFile($lang);
      $template = DynamicArrayCatalog::fromFile($transDir . '_tpl.php');

      foreach($template->getData() as $mid => $options)
      {
        if($poEdit->getTranslation($mid) instanceof PoTranslation)
        {
          //Trust the existing po translation is correct
          continue;
        }

        $tran = new PoTranslation($mid);
        $tran->setReferences([$mid]);
        $tran->setSingularSource($mid);

        //New translation, needs work
        $tran->setNeedsWork(true);

        if(isset($options[Message::DEFAULT_OPTION]) && !empty($options[Message::DEFAULT_OPTION]))
        {
          $tran->setComments(explode(PHP_EOL, $options[Message::DEFAULT_OPTION]));
          $tran->setSingularSource($this->_getTranslation($options[Message::DEFAULT_OPTION], LanguageCode::CODE_EN));
          $tran->setSingularTranslation($this->_getTranslation($options[Message::DEFAULT_OPTION], $lang));
          unset($options[Message::DEFAULT_OPTION]);
        }

        if(isset($options['n']))
        {
          $tran->setPluralSource($mid . '__plural');
          $tran->setPluralTranslation($options['n']);
          unset($options['n']);
        }

        $tran->setAdditionalPluralTranslations($options);
        $poEdit->addTranslation($tran);
      }

      file_put_contents($poLoc, (string)$poEdit);

      echo PHP_EOL;
    }
  }

  /**
   * @param $text
   * @param $lang
   *
   * @return string
   */
  protected function _getTranslation($text, $lang): string
  {
    return AutoTranslate::translate($this->getContext(), $text, $lang);
  }
}
