<?php

namespace Sven\FileConfig\Tests\Drivers;

use Sven\FileConfig\Drivers\Driver;
use Sven\FileConfig\Drivers\Json;

class JsonDriverTestCase extends DriverTestCase
{
    public static function files(): array
    {
        return [
            [
                'Empty file',
                '{}',
                [],
            ],
            [
                'A single value',
                '{"one":"two"}',
                ['one' => 'two'],
            ],
            [
                'Multidimensional array',
                '{"one":{"two":{"three":{"0":"four","1":"five","2":"six"}}}}',
                ['one' => ['two' => ['three' => ['four', 'five', 'six']]]],
            ],
        ];
    }

    protected function driver(): Driver
    {
        return new Json();
    }
}
