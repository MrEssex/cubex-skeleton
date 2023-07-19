<?php
namespace CubexBase\Application\Cli;

use CubexBase\Application\Context\Providers\DatabaseProvider;
use Exception;
use MrEssex\CubexCli\ConsoleCommand;
use Packaged\Dal\Exceptions\DalResolver\ConnectionNotFoundException;
use Packaged\Dal\Exceptions\DalResolver\DataStoreNotFoundException;
use Packaged\Dal\Foundation\Dao;
use Packaged\Dal\Ql\QlDataStore;
use Packaged\DalSchema\DalSchema;
use ReflectionException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Migrate extends ConsoleCommand
{
  /**
   * @throws ReflectionException
   * @throws DataStoreNotFoundException
   * @throws ConnectionNotFoundException
   * @throws Exception
   */
  public function executeCommand(InputInterface $input, OutputInterface $output): void
  {
    $schemas = DalSchema::findSchemas(dirname(__DIR__), 'CubexBase\\Application\\');
    $ctx = $this->getContext();
    DatabaseProvider::instance($ctx)->registerDatabaseConnections($ctx->getEnvironment());

    foreach($schemas as $schema)
    {
      $schema->getName();
      $name = 'cubex-base';
      $resolver = Dao::getDalResolver();
      $datastore = $resolver->getDataStore($name);
      if(!$datastore instanceof QlDataStore)
      {
        return;
      }
      $connection = $datastore->getConnection();

      $output->writeln("Migrating Table: {$schema->getName()}");
      DalSchema::migrateTables($connection, $datastore->getConfig()->getItem('connection'), ...$schemas);
    }
  }
}
