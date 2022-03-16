<?php
namespace CubexBase\Application\Api\Storage;

use Packaged\Dal\Ql\QlDao;
use Packaged\Helpers\Objects;

abstract class AbstractStorage extends QlDao
{
  protected $_dataStoreName = 'cubex-base';

  public ?int $id;

  public bool $active = true;

  public string $created_at = '';
  public ?string $updated_at;
  public ?string $deleted_at;

  public function save()
  {
    if(!$this->id)
    {
      $this->created_at = date('Y-m-d H:i:s');
    }
    $this->updated_at = date('Y-m-d H:i:s');
    return parent::save();
  }

  public function delete()
  {
    $this->deleted_at = date('Y-m-d H:i:s');
    $this->active = false;
    $this->save();

    return $this;
  }

  public function restore()
  {
    $this->deleted_at = null;
    $this->active = true;
    $this->save();

    return $this;
  }

  public static function active()
  {
    return parent::each(['active' => 1]);
  }

  abstract protected function _getResponse();

  public function toApiResponse()
  {
    return Objects::hydrate($this->_getResponse(), $this);
  }
}
