<?php

use CubexBase\Application\Components\ButtonComponent;

test('Button Component Renders', function () {
  $button = new ButtonComponent('Example');
  expect($button->render())->toBe('<button class="btn">Example</button>');
});
