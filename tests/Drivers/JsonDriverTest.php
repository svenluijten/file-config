<?php

namespace Sven\FileConfig\Tests\Drivers;

use Sven\FileConfig\Drivers\Driver;
use Sven\FileConfig\Drivers\Json;

class JsonDriverTest extends DriverTest
{
    public function files(): array
    {
        return [
            ['{}', []],
            ['{"one":"two"}', ['one' => 'two']],
            ['{"one":{"two":{"three":{"0":"four","1":"five","2":"six"}}}}', ['one' => ['two' => ['three' => ['four', 'five', 'six']]]]],
        ];
    }

    protected function driver(): Driver
    {
        return new Json();
    }
}
