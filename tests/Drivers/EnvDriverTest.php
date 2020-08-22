<?php

namespace Sven\FileConfig\Tests\Drivers;

use Sven\FileConfig\Drivers\Driver;
use Sven\FileConfig\Drivers\Env;

/**
 * @deprecated
 */
class EnvDriverTest extends DriverTest
{
    public function files(): array
    {
        return [
            [
                'One simple value',
                'FOO=bar'.PHP_EOL,
                [
                    'FOO' => 'bar',
                ],
            ],
            [
                'Multiple values in one file',
                'FOO=bar'.PHP_EOL.'BAZ=qux'.PHP_EOL,
                [
                    'FOO' => 'bar',
                    'BAZ' => 'qux',
                ],
            ],
            [
                'Quoted values',
                'FOO="bar"'.PHP_EOL.'BAZ=qux'.PHP_EOL,
                [
                    'FOO' => '"bar"',
                    'BAZ' => 'qux',
                ],
            ],
            [
                'A single comment',
                '# A comment'.PHP_EOL,
                [
                    '# A comment',
                ],
            ],
            [
                'A comment between two values',
                'HELLO=world'.PHP_EOL.'# A comment'.PHP_EOL.'GOODBYE=world'.PHP_EOL,
                [
                    'HELLO' => 'world',
                    1 => '# A comment',
                    'GOODBYE' => 'world',
                ],
            ],
            [
                'Multiple newlines between values',
                'FOO=bar'.PHP_EOL.'ABC=xyz'.PHP_EOL.PHP_EOL.'GHI=jkl'.PHP_EOL,
                [
                    'FOO' => 'bar',
                    'ABC' => 'xyz',
                    2 => '',
                    'GHI' => 'jkl',
                ],
            ],
            [
                'Numeric keys',
                'FOO=bar'.PHP_EOL.'# A comment'.PHP_EOL.'KEY=value'.PHP_EOL.PHP_EOL.'# Second comment'.PHP_EOL.'KEY_2="value number two"'.PHP_EOL,
                [
                    'FOO' => 'bar',
                    1 => '# A comment',
                    'KEY' => 'value',
                    3 => '',
                    4 => '# Second comment',
                    'KEY_2' => '"value number two"',
                ],
            ],
            [
                'Empty values',
                'FOO='.PHP_EOL.'HELLO=world'.PHP_EOL,
                [
                    'FOO' => '',
                    'HELLO' => 'world',
                ],
            ],
        ];
    }

    protected function driver(): Driver
    {
        return new Env();
    }
}
