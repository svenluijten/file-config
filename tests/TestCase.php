<?php

namespace Sven\FileConfig\Tests;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected const TEMP_DIRECTORY = 'temp';

    public function setUp(): void
    {
        $this->filesystem()->createDirectory(self::TEMP_DIRECTORY);
    }

    public function tearDown(): void
    {
        $this->filesystem()->deleteDirectory(self::TEMP_DIRECTORY);
    }

    protected function filesystem(): Filesystem
    {
        $adapter = new LocalFilesystemAdapter(__DIR__);

        return new Filesystem($adapter);
    }

    /**
     * @param  string  $path
     * @param  string  $contents
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    protected function create(string $path, string $contents = ''): void
    {
        $this->filesystem()->write(
            self::TEMP_DIRECTORY.DIRECTORY_SEPARATOR.$path, $contents
        );
    }
}
