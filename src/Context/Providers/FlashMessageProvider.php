<?php

namespace CubexBase\Application\Context\Providers;

use Packaged\Context\Context;
use Packaged\Http\Cookies\Cookie;
use Packaged\Http\Request;

/**
 * @method static FlashMessageProvider instance(Context $context, ...$args)
 */
class FlashMessageProvider extends AbstractProvider
{
  protected array $_messages = [];

  public function __construct(Request $request)
  {
    $cookie = $request->cookies->get('flash');
    if($cookie)
    {
      $this->_messages = json_decode($cookie, true);
    }
  }

  public function hasMessages(): bool
  {
    return !empty($this->_messages);
  }

  public function addMessage(string $type, string $message): static
  {
    $this->_messages[] = ["type" => $type, "message" => $message];
    return $this;
  }

  public function getMessages(): array
  {
    $messages = $this->_messages;

    // Clear messages
    $this->_messages = [];

    return $messages;
  }

  public function toCookie(): Cookie
  {
    return new Cookie('flash', json_encode($this->_messages), time() + 60);
  }
}
