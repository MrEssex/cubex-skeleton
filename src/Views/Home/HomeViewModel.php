<?php

namespace CubexBase\Application\Views\Home;

use Cubex\Mv\ViewModel;
use CubexBase\Transport\Modules\Example\Responses\ExamplesResponse;

class HomeViewModel extends ViewModel
{
  protected string $_defaultView = HomeView::class;

  public ExamplesResponse $examples;
}
