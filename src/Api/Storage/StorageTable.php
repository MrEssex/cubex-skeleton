<?php
namespace CubexBase\Application\Api\Storage;

use Packaged\DalSchema\Databases\Mysql\MySQLColumn;
use Packaged\DalSchema\Databases\Mysql\MySQLColumnType;
use Packaged\DalSchema\Databases\Mysql\MySQLKey;
use Packaged\DalSchema\Databases\Mysql\MySQLKeyType;
use Packaged\DalSchema\Databases\Mysql\MySQLTable;

class StorageTable extends MySQLTable
{
  public function __construct($name)
  {
    parent::__construct($name, '');
    $this->addColumn(
      new MySQLColumn('id', MySQLColumnType::INT_UNSIGNED(), null, false, null, MySQLColumn::EXTRA_AUTO_INCREMENT),
      new MySQLColumn('active', MySQLColumnType::TINY_INT_UNSIGNED(), null, false, 1),
      new MySQLColumn('created_at', MySQLColumnType::DATETIME()),
      new MySQLColumn('updated_at', MySQLColumnType::DATETIME(), null, true),
      new MySQLColumn('deleted_at', MySQLColumnType::DATETIME(), null, true)
    );

    $this->addKey(new MySQLKey('id', MySQLKeyType::PRIMARY(), 'id'));
  }
}
