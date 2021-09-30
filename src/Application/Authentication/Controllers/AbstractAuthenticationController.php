<?php
namespace CubexBase\Application\Application\Authentication\Controllers;

use CubexBase\Application\Controllers\AbstractController;

class AbstractAuthenticationController extends AbstractController
{
  public function canProcess(&$response): bool
  {
    $whitelist = ['login', 'register'];
    return in_array(
      ltrim($this->getContext()->request()->offsetPath(1), '/'),
      $whitelist
    );
  }
}
