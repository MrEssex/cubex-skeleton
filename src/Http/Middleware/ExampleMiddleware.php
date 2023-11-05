<?php

namespace CubexBase\Application\Http\Middleware;

use Cubex\Middleware\Middleware;
use Packaged\Context\Context;
use Packaged\Http\Responses\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ExampleMiddleware extends Middleware
{
  public function handle(Context $c): Response
  {
    //    example middleware
    echo "<pre>Pre Middleware</pre><br>";
    $response = $this->next($c);
    echo $response->getContent();
    echo "<br><pre>Post Middleware</pre>";

    // redirect to home page
    return RedirectResponse::create('/');
    return $response;
  }
}
