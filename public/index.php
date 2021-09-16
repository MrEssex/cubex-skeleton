<?php

define('PHP_START', microtime(true));

use Composer\Autoload\ClassLoader;
use Cubex\Cubex;
use CubexBase\Application\Context\Context as CustomContext;
use CubexBase\Application\MainApplication;
use Packaged\Context\Context;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

$projectRoot = dirname(__DIR__);

/** @var ClassLoader $loader */
$loader = require($projectRoot . '/vendor/autoload.php');

$cubex = Cubex::withCustomContext(CustomContext::class, $projectRoot, $loader);

try
{
  $cubex->handle(new MainApplication($cubex), true);
}
catch(Throwable $e)
{
  if($cubex->getContext()->isEnv(Context::ENV_LOCAL))
  {
    $handler = new Run();
    $handler->pushHandler(new PrettyPageHandler());
    $handler->handleException($e);
  }
  else
  {
    error_log($e->getMessage());
    die('Unable to handle your request');
  }
}
finally
{
  if($cubex instanceof Cubex)
  {
    try
    {
      $cubex->shutdown();
    }
    catch(Exception $e)
    {
    }
  }
}
