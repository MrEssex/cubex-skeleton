<?php

define('PHP_START', microtime(true));

use Composer\Autoload\ClassLoader;
use Cubex\Cubex;
use FusionBase\Application\Context\Context as FContext;
use FusionBase\Application\MainApplication;
use Packaged\Context\Context;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/** @var string $projectRoot */
$projectRoot = dirname(__DIR__);
/** @var ClassLoader $loader */
$loader = require_once($projectRoot . '/vendor/autoload.php');

try {
  $cubex = Cubex::withCustomContext(FContext::class, $projectRoot, $loader);
  $cubex->handle(new MainApplication($cubex), true);
}
catch (Throwable $e) {
  if ($cubex && $cubex->getContext()->isEnv(Context::ENV_LOCAL)) {
    $handler = new Run();
    $handler->pushHandler(new PrettyPageHandler());
    $handler->handleException($e);
  }
  else {
    error_log($e->getMessage());
    die('Unable to handle your request');
  }
}
finally {
  if ($cubex instanceof Cubex) {
    $cubex->shutdown();
  }
}
