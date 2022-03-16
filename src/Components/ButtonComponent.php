<?php
namespace CubexBase\Application\Components;

class ButtonComponent extends AbstractComponent
{
  protected $_tag = 'button';
  protected ?string $_content;

  public function __construct($content = null)
  {
    parent::__construct();
    $this->_content = $content;
  }

  public function getBlockName(): string
  {
    return 'btn';
  }

  public static function primary($ctx, $content)
  {
    $b = self::withContext($ctx, $content);
    $b->addClass('bg-blue-400', 'text-white');
    return $b;
  }

  public static function secondary($ctx, $content)
  {
    $b = self::withContext($ctx, $content);
    $b->addClass('bg-orange-400', 'text-white');
    return $b;
  }

  protected function _getContentForRender(): ?string
  {
    return $this->_content;
  }

  protected function _defaultClasses(): array
  {
    return [
      'rounded',
      'px-4',
      'py-2',
    ];
  }
}
