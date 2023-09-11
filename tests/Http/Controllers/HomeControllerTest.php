<?php

namespace CubexBase\Tests\Http\Controllers;

use CubexBase\Tests\Support\TestCase;

class HomeControllerTest extends TestCase
{
  public function testHomePageRendersCorrectly(): void
  {
    $response = $this->call('GET', '/');
    $response->assertStatus(200);

    // Ensure the correct resources are been applied to the layout
    $regex = '#<link href="/_res/r/.*/main.min.css" rel="stylesheet" type="text/css">#';
    $this->assertMatchesRegularExpression($regex, $response->getContent());
    $regex = '#<script src="/_res/r/.*/main.min.js"></script>#';
    $this->assertMatchesRegularExpression($regex, $response->getContent());

    $this->assertStringContainsString('Hello World', $response->getContent());
  }
}
