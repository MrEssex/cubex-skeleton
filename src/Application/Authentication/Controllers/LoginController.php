<?php
namespace CubexBase\Application\Application\Authentication\Controllers;

use CubexBase\Application\Application\Authentication\Pages\LoginPage\LoginPage;
use CubexBase\Application\Controllers\AbstractController;

class LoginController extends AbstractController
{
  public function get()
  {
    return LoginPage::withContext($this);
  }
}
