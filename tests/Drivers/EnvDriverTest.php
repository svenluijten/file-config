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
                    ['FOO' => 'bar'],
                ],
            ],
            [
                'Multiple values in one file',
                "FOO=bar\nBAZ=qux\n",
                [
                    ['FOO' => 'bar'],
                    ['BAZ' => 'qux'],
                ],
            ],
            [
                'Quoted values',
                "FOO=\"bar\"\nBAZ=qux\n",
                [
                    ['FOO' => '"bar"'],
                    ['BAZ' => 'qux'],
                ],
            ],
            [
                'A single comment',
                "# A comment\n",
                [
                    ['# A comment'],
                ],
            ],
            [
                'A comment between two values',
                "HELLO=world\n# A comment\nGOODBYE=world\n",
                [
                    ['HELLO' => 'world'],
                    ['# A comment'],
                    ['GOODBYE' => 'world'],
                ],
            ],
            [
                'Multiple newlines between values',
                "FOO=bar\nABC=xyz\n\nGHI=jkl\n",
                [
                    ['FOO' => 'bar'],
                    ['ABC' => 'xyz'],
                    [''],
                    ['GHI' => 'jkl'],
                ],
            ],
            [
                'Numeric keys',
                "FOO=bar\n# A comment\nKEY=value\n\n# Second comment\nKEY_2=\"value number two\"\n",
                [
                    ['FOO' => 'bar'],
                    ['# A comment'],
                    ['KEY' => 'value'],
                    [''],
                    ['# Second comment'],
                    ['KEY_2' => '"value number two"'],
                ],
            ],
        ];
    }

    protected function driver(): Driver
    {
        return new Env();
    }
}
