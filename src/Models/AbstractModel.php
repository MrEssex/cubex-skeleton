<?php
namespace CubexBase\Application\Models;

use Packaged\Dal\Ql\QlDao;

abstract class AbstractModel extends QlDao
{
  protected $_dataStoreName = 'cubex-base';

  public $id;
  public $createdAt;
  public $updatedAt;
}
