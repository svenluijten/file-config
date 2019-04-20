<?php

namespace Sven\FileConfig\Tests\Drivers;

use Sven\FileConfig\Drivers\Driver;
use Sven\FileConfig\Tests\TestCase;

abstract class DriverTest extends TestCase
{
    /**
     * @dataProvider files
     *
     * @param \Sven\FileConfig\Drivers\Driver $driver
     * @param string                          $contents
     * @param array                           $config
     */
    public function test_it_can_import_and_export_files(Driver $driver, string $contents, array $config): void
    {
        $imported = $driver->import($contents);
        $exported = $driver->export($config);

        $this->assertEquals($config, $imported);
        $this->assertEquals($contents, $exported);
    }

    /**
     * This data provider should return the driver to be used,
     * the original contents of the file, and the expected
     * PHP array, in that order.
     *
     * @return array
     *
     * @see \Sven\FileConfig\Tests\Drivers\JsonDriverTest::files
     */
    abstract public function files(): array;
}
