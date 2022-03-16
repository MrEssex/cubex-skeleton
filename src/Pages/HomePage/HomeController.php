<?php

namespace CubexBase\Application\Pages\HomePage;

use CubexBase\Application\Api\Modules\Example\Procedures\ListExample;
use CubexBase\Application\Layout\LayoutController;
use CubexBase\Transport\Modules\Example\Payloads\ListExamplePayload;

class HomeController extends LayoutController
{
  public function get()
  {
    $model = HomeViewModel::withContext($this);

    $example = ListExample::withContext($this);
    $model->examples = $example->execute(ListExamplePayload::i());

    return $model->setDefaultView(HomeView::class);
  }
}
