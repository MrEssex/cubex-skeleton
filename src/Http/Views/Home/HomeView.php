<?php

namespace CubexBase\Application\Http\Views\Home;

use CubexBase\Application\Http\Forms\ExampleForm\ExampleForm;
use CubexBase\Application\Http\Views\AbstractView;

class HomeView extends AbstractView
{
  protected ?ExampleForm $form = null;

  public function getBlockName(): string
  {
    return 'home';
  }

  public function setForm(ExampleForm $form): HomeView
  {
    $this->form = $form;
    return $this;
  }

  public function getForm(): ?ExampleForm
  {
    return $this->form;
  }

  /**
   * Should this page be cached?
   *
   * @return bool
   */
  public function shouldCache(): bool
  {
    return false;
  }

  /**
   * Should this page be indexed?
   *
   * @return bool
   */
  public function shouldIndex(): bool
  {
    return true;
  }
}
