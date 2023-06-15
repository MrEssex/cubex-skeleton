<?php

namespace CubexBase\Application\Views;

use Cubex\I18n\GetTranslatorTrait;
use CubexBase\Application\AbstractBase;
use Packaged\Context\Conditions\ExpectEnvironment;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;
use Packaged\SafeHtml\ISafeHtmlProducer;
use Packaged\SafeHtml\SafeHtml;
use Packaged\Ui\TemplateLoaderTrait;
use PackagedUi\BemComponent\BemComponent;
use PackagedUi\BemComponent\BemComponentTrait;
use Throwable;

abstract class AbstractView extends \Cubex\Mv\AbstractView
  implements CachableView, WithContext, BemComponent, Translatable
{
  use TemplateLoaderTrait;
  use BemComponentTrait;
  use TranslatableTrait;
  use GetTranslatorTrait;
  use WithContextTrait;

  /**
   * @return ISafeHtmlProducer|null
   * @throws Throwable
   */
  protected function _render(): ?ISafeHtmlProducer
  {
    return new SafeHtml($this->_renderTemplate());
  }

  public function getPageClass(): string
  {
    return $this->getBlockName();
  }

  public function shouldCache(): bool
  {
    return !$this->getContext()->matches(ExpectEnvironment::local());
  }

  public function getHeader(): ?AbstractBase { return null; }

  public function getFooter(): ?AbstractBase { return null; }
}
