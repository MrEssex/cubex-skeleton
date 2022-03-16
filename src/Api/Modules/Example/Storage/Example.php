<?php
namespace CubexBase\Application\Api\Modules\Example\Storage;

use CubexBase\Application\Api\Storage\AbstractStorage;
use CubexBase\Application\Api\Storage\StorageTable;
use CubexBase\Transport\Modules\Example\Responses\ExampleResponse;
use Packaged\DalSchema\Databases\Mysql\MySQLColumn;
use Packaged\DalSchema\Databases\Mysql\MySQLColumnType;
use Packaged\DalSchema\Table;

class Example extends AbstractStorage
{
  public string $title = '';
  public ?string $description;

  protected function _apiResponseClass(): ExampleResponse
  {
    return new ExampleResponse();
  }

  public function getDaoSchema(): Table
  {
    $tbl = new StorageTable($this->getTableName());
    $tbl->addColumn(
      new MySQLColumn('title', MySQLColumnType::VARCHAR()),
      new MySQLColumn('description', MySQLColumnType::TEXT())
    );

    return $tbl;
  }
}
