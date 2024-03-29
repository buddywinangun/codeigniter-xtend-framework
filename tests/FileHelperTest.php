<?php

use PHPUnit\Framework\TestCase;
use CodeigniterXtend\Framework\Helpers\FileHelper;

const TMP_DIR = __DIR__ . '/temp';
const INPUT_DIR = __DIR__ . '/input';

final class FileHelperTest extends TestCase
{
  public static function setUpBeforeClass(): void
  {
    // During testing, files in the input directory are overwritten, so reset the input directory before testing.
    FileHelper::delete(TMP_DIR);
    FileHelper::copyDirectory(INPUT_DIR, TMP_DIR);
  }

  public function testDeleteDirectoriesRecursively(): void
  {
    $deleteSelf = true;
    $dir = TMP_DIR . '/recursively-delete';
    FileHelper::delete($dir, $deleteSelf);
    $this->assertSame(file_exists($dir), false);
  }

  public function testDeleteRecursivelyOnlyChildrenOfDirectory(): void
  {
    $deleteSelf = false;
    $dir = TMP_DIR . '/recursively-delete-only-children';
    FileHelper::delete($dir, $deleteSelf);
    $numberOfFiles = count(glob($dir . '/*'));
    $this->assertSame($numberOfFiles, 0);
  }

  public function testMakeDirector(): void
  {
    $dir = TMP_DIR . '/path';
    FileHelper::makeDirectory($dir);
    $directoryExists = file_exists($dir);
    $this->assertSame($directoryExists, true);
  }

  public function testMakeDirectorAlreadyExists(): void
  {
    $dir = TMP_DIR . '/path';
    FileHelper::makeDirectory($dir);
    $directoryExists = file_exists($dir);
    $this->assertSame($directoryExists, true);
  }
}
