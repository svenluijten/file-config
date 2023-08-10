<?php

namespace Sven\FileConfig\Tests\Drivers;

use PHPUnit\Framework\TestCase;
use Sven\FileConfig\Drivers\Driver;

abstract class DriverTest extends TestCase
{
    /**
     * @dataProvider files
     *
     * @param  string  $title
     * @param  string  $contents
     * @param  array  $config
     *
     * @throws \Exception
     */
    public function test_it_can_import_and_export_files(string $title, string $contents, array $config): void
    {
        $this->assertEquals(
            $config,
            $this->driver()->import($contents),
            'Failed converting test case "'.$title.'" into an array (importing).'
        );

        $this->assertEquals(
            $contents,
            $this->driver()->export($config),
            'Failed converting test case "'.$title.'" back into a string (exporting).'
        );
    }

    /**
     * This data provider should return the title of the test
     * case, the original contents of the file, and then
     * the expected PHP array, in that order.
     *
     * @see \Sven\FileConfig\Tests\Drivers\JsonDriverTest::files
     *
     * @return array
     */
    abstract public static function files(): array;

    abstract protected function driver(): Driver;
}
