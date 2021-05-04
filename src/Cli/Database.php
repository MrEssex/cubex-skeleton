<?php

namespace CubexBase\Application\Cli;

use Cubex\Console\ConsoleCommand;
use Packaged\DalSchema\DalSchema;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Databse
 *
 * @package CubexBase\Application\Cli
 */
class Database extends ConsoleCommand
{

  protected function _execute(InputInterface $input, OutputInterface $output)
  {
    $schemas = DalSchema::findSchemas(__DIR__ . '/../Database', 'CubexBase\Application\Database');

    foreach($schemas as $schema)
    {
      $schema->writerCreate();
    }
  }
}
