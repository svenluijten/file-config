<?php

namespace Sven\FileConfig\Tests\Drivers;

use Sven\FileConfig\Drivers\Driver;
use Sven\FileConfig\Drivers\Env;

class EnvDriverTest extends DriverTest
{
    public function files(): array
    {
        return [
            [
                'One simple value',
                "FOO=bar\n",
                [
                    'FOO' => 'bar',
                ],
            ],
            [
                'Multiple values in one file',
                "FOO=bar\nBAZ=qux\n",
                [
                    'FOO' => 'bar',
                    'BAZ' => 'qux',
                ],
            ],
            [
                'Quoted values',
                "FOO=\"bar\"\nBAZ=qux\n",
                [
                    'FOO' => '"bar"',
                    'BAZ' => 'qux',
                ],
            ],
            [
                'A single comment',
                "# A comment\n",
                [
                    '# A comment',
                ],
            ],
            [
                'A comment between two values',
                "HELLO=world\n# A comment\nGOODBYE=world\n",
                [
                    'HELLO' => 'world',
                    1 => '# A comment',
                    'GOODBYE' => 'world',
                ],
            ],
            [
                'Multiple newlines between values',
                "FOO=bar\nABC=xyz\n\nGHI=jkl\n",
                [
                    'FOO' => 'bar',
                    'ABC' => 'xyz',
                    2 => '',
                    'GHI' => 'jkl',
                ],
            ],
            [
                'Numeric keys',
                "FOO=bar\n# A comment\nKEY=value\n\n# Second comment\nKEY_2=\"value number two\"\n",
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
                "FOO=\nHELLO=world\n",
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
