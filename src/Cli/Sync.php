<?php


namespace CubexBase\Application\Cli;


use Cubex\Console\ConsoleCommand;
use CubexBase\Application\Database\Article;
use Packaged\Helpers\Path;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function file_exists;
use function file_put_contents;
use function json_encode;
use function mkdir;
use function strtolower;
use function unlink;

/**
 * Class Sync
 * @package CubexBase\Application\Cli
 */
class Sync extends ConsoleCommand
{

  /**
   * @param InputInterface $input
   * @param OutputInterface $output
   */
  public function executeCommand(InputInterface $input, OutputInterface $output): void
  {
    $output->writeln("Syncing all the things");

    $dataDir = Path::system($this->getContext()->getProjectRoot(), 'data');
    // Articles
    $articlesDir = $this->_assertDir(Path::system($dataDir, 'articles'));

    /** @var Article $article */
    foreach (Article::collection() as $article) {
      $path = Path::system($articlesDir, strtolower($article->slug) . '.json');

      if ($article->active) {
        file_put_contents($path, json_encode($article->jsonSerialize(), JSON_THROW_ON_ERROR));
      }

      elseif (file_exists($path)) {
        unlink($path);
      }
    }
  }

  /**
   * @param $dir
   * @return mixed
   */
  protected function _assertDir($dir)
  {
    if (!file_exists($dir) && !mkdir($dir) && !is_dir($dir)) {
      throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
    }
    return $dir;
  }
}