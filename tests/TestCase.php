<?php

namespace Sven\FileConfig\Tests;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected const TEMP_DIRECTORY = 'temp';

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->filesystem()->createDir(self::TEMP_DIRECTORY);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown(): void
    {
        $this->filesystem()->deleteDir(self::TEMP_DIRECTORY);
    }

    /**
     * @return \League\Flysystem\Filesystem
     */
    protected function filesystem(): Filesystem
    {
        $adapter = new Local(__DIR__);

        return new Filesystem($adapter);
    }

    /**
     * @param string $path
     * @param string $contents
     *
     * @return bool
     *
     * @throws \League\Flysystem\FileExistsException
     */
    protected function create(string $path, string $contents = ''): bool
    {
        return $this->filesystem()->write(
            self::TEMP_DIRECTORY.DIRECTORY_SEPARATOR.$path, $contents
        );
    }
}
