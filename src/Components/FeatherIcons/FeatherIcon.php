<?php

namespace CubexBase\Application\Components\FeatherIcons;

use CubexBase\Application\Components\AbstractComponent;
use Packaged\SafeHtml\SafeHtml;
use Throwable;

/**
 * Class FeatherIcon
 * @package CubexBase\Application\Components\FeatherIcons
 */
class FeatherIcon extends AbstractComponent
{

  /** @var string */
  protected $_tag = 'svg';

  /** @var int */
  protected int $_width = 16;
  /** @var int */
  protected int $_height = 16;
  /** @var string */
  private string $_xmlns = "http://www.w3.org/2000/svg";
  /** @var string */
  protected string $_filename;
  /** @var string */
  protected string $_resources = __DIR__ . DIRECTORY_SEPARATOR . '_resources' . DIRECTORY_SEPARATOR . 'svg' . DIRECTORY_SEPARATOR;

  /**
   * @return string
   */
  public function getBlockName(): string
  {
    return 'feather';
  }

  /**
   * FeatherIcon constructor.
   *
   * @param FeatherIcons $filename
   */
  public function __construct(FeatherIcons $filename)
  {
    $this->_filename = $filename;
    $this->setAttributes(
      [
        'xmlns' => $this->_xmlns,
        'height' => $this->_height . 'px',
        'width' => $this->_width . 'px',
        "fill" => "none",
        "stroke" => "currentColor",
        "stroke-linecap" => "round",
        "stroke-linejoin" => "round",
        "stroke-width" => "2",
        "viewbox" => "0 0 24 24",
      ]
    );
    $this->addClass('feather-' . $filename);
    parent::__construct();
  }

  /**
   * @return SafeHtml|null
   * @throws Throwable
   */
  protected function _getContentForRender(): ?SafeHtml
  {
    return new SafeHtml($this->_loadSVGContent($this->_filename));
  }

  /**
   * @param string $filename
   *
   * @return string
   */
  private function _loadSVGContent(string $filename): string
  {
    $key = 'feather-icons:' . $filename;

    if (!apcu_exists($key)) {
      $fileContents = file_get_contents($this->_resources . $filename . '.svg');
      preg_match('/<svg.*?>(.*?)<\/svg>/m', $fileContents, $matches);
      apcu_add($key, $matches[1], 60 * 60);
      return $matches[1];
    }

    return apcu_fetch($key);
  }
}
