<?php

namespace Sven\FileConfig\Tests;

use League\Flysystem\Adapter\Local;
use League\Flysystem\File;
use League\Flysystem\Filesystem;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function file(string $path): File
    {
        $adapter = new Local(__DIR__.'/fixtures');

        $filesystem = new Filesystem($adapter);

        return new File($filesystem, $path);
    }
}
