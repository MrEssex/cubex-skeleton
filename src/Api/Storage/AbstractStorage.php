<?php
namespace CubexBase\Application\Api\Storage;

use Exception;
use Packaged\Dal\Ql\QlDao;
use Packaged\DalSchema\DalSchemaProvider;
use Packaged\Helpers\Objects;

abstract class AbstractStorage extends QlDao implements DalSchemaProvider
{
  protected $_dataStoreName = 'cubex-base';

  public ?int $id;

  public bool $active = true;

  public string $created_at = '';
  public ?string $updated_at;
  public ?string $deleted_at;

  public function save(): array
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

  public function restore(): AbstractStorage
  {
    $this->deleted_at = null;
    $this->active = true;
    $this->save();

    return $this;
  }

  public static function active(): array
  {
    return parent::each(['active' => 1]);
  }

  abstract protected function _apiResponseClass();

  /**
   * @throws Exception
   */
  public function toApiResponse()
  {
    return Objects::hydrate($this->_apiResponseClass(), $this);
  }
}
