<?php

namespace CubexBase\Application\Context;

use Cubex\Context\Context;
use Cubex\I18n\GetTranslatorTrait;
use Packaged\Http\LinkBuilder\LinkBuilder;
use Packaged\I18n\Translatable;
use Packaged\I18n\TranslatableTrait;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AppContext extends Context implements Translatable
{
  use TranslatableTrait;
  use GetTranslatorTrait;

  /**
   * @param string   $path
   * @param string[] $query
   *
   * @return LinkBuilder
   */
  public function linkBuilder(string $path = '', array $query = []): LinkBuilder
  {
    return LinkBuilder::fromRequest($this->request(), $path, $query)->setSubDomain('www');
  }

  public function getSiteName(): string
  {
    return 'Cubex Base';
  }

  public function getSession(): SessionInterface
  {
    if(!$this->request()->hasSession())
    {
      $this->request()->setSession(new Session());
    }

    return $this->request()->getSession();
  }

  public function getFlashBag(): FlashBag
  {
    if(!$this->getSession()->has('flashes'))
    {
      $this->getSession()->set('flashes', new FlashBag());
    }

    /** @var FlashBag $sessionBag */
    $sessionBag = $this->getSession()->getBag('flashes');
    return $sessionBag;
  }
}
