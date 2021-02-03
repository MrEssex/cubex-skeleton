<?php
namespace CubexBase\Application\I18n;

use Packaged\Context\Context;
use Packaged\Rwd\Language\LanguageCode;
use Statickidz\GoogleTranslate;

/**
 * Class AutoTranslate
 * @package CubexBase\Application\I18n
 */
class AutoTranslate
{
  /** @var array $common */
  public static array $common = [
    LanguageCode::CODE_EN,
    LanguageCode::CODE_ES,
    LanguageCode::CODE_FR,
  ];

  /** @var GoogleTranslate */
  protected static $_client;

  /**
   * @param Context $ctx
   * @param         $text
   * @param         $languageCode
   *
   * @return string
   */
  public static function translate(Context $ctx, $text, $languageCode): string
  {
    if(empty($text) || $languageCode === LanguageCode::CODE_EN)
    {
      return $text;
    }

    if(static::$_client === null)
    {
      static::$_client = new GoogleTranslate();
    }

    if(static::$_client instanceof GoogleTranslate)
    {
      $text = static::$_client::Translate('en', $languageCode, $text);
    }

    return $text;
  }
}
