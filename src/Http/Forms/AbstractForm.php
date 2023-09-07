<?php

namespace CubexBase\Application\Http\Forms;

use Cubex\I18n\GetTranslatorTrait;
use Packaged\Context\ContextAware;
use Packaged\Context\ContextAwareTrait;
use Packaged\Context\WithContext;
use Packaged\Context\WithContextTrait;
use Packaged\Form\Csrf\CsrfForm;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;

abstract class AbstractForm extends CsrfForm implements ContextAware, Translatable, WithContext
{
  use ContextAwareTrait;
  use TranslatableTrait;
  use GetTranslatorTrait;
  use WithContextTrait;
}

