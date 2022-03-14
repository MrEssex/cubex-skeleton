<?php

use CubexBase\Application\Components\ButtonComponent;

test('Button Component Renders', function () {
  $button = new ButtonComponent();
  expect($button->render())->toBe('<button class="btn"></button>');
});
