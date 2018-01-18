<?php

namespace Sven\FileConfig\Tests;

use League\Flysystem\Adapter\Local;
use League\Flysystem\File;
use League\Flysystem\Filesystem;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    private const TEMP_DIRECTORY = 'temp';

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->filesystem()->createDir(self::TEMP_DIRECTORY);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
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
     *
     * @return \League\Flysystem\File
     */
    protected function file(string $path): File
    {
        return new File($this->filesystem(), self::TEMP_DIRECTORY.'/'.$path);
    }

    /**
     * @param string $path
     * @param string $contents
     *
     * @return bool
     */
    protected function create($path, $contents = ''): bool
    {
        return $this->filesystem()->write(self::TEMP_DIRECTORY.'/'.$path, $contents);
    }
}
