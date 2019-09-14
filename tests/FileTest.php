<?php

namespace Sven\FileConfig\Tests;

use Sven\FileConfig\File;

class FileTest extends TestCase
{
    /** @test */
    public function it_can_read_and_update_a_file(): void
    {
        $this->create('test.txt', 'content of the file');
        $file = new File(__DIR__.'/'.self::TEMP_DIRECTORY.'/test.txt');

        $this->assertEquals('content of the file', $file->contents());

        $file->update('new contents of the file');

        $this->assertEquals('new contents of the file', $file->contents());
    }
}
