<?php
namespace CubexBase\Application\Api\Storage;

use Cubex\ApiTransport\Responses\ApiResponse;
use Packaged\Dal\Ql\QlDao;

abstract class AbstractStorage extends QlDao
{
  protected $_dataStoreName = 'cubex-base';

  public ?int $id;

  public bool $active = true;

  public string $created_at = '';
  public ?string $updated_at;
  public ?string $deleted_at;
  protected ApiResponse $_response;

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
    $r = $this->_getResponse();
    $r->id = $this->id;
    $r->active = $this->active;
    $r->created_at = $this->created_at;
    $r->updated_at = $this->updated_at;
    $r->deleted_at = $this->deleted_at;
    return $r;
  }
}
