<?php
namespace CubexBase\Application\Pages\HomePage;

use Cubex\Mv\ViewModel;
use CubexBase\Transport\Modules\Example\Responses\ExamplesResponse;

class HomeViewModel extends ViewModel
{
  public ExamplesResponse $examples;
}
