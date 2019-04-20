<?php

namespace Sven\FileConfig\Tests\Drivers;

use Sven\FileConfig\Drivers\Json;

class JsonDriverTest extends DriverTest
{
    public function files(): array
    {
        return [
            [new Json, '{}', []],
            [new Json, '{"one":"two"}', ['one' => 'two']],
            [new Json, '{"one":{"two":{"three":{"0":"four","1":"five","2":"six"}}}}', ['one' => ['two' => ['three' => ['four', 'five', 'six']]]]],
        ];
    }
}
