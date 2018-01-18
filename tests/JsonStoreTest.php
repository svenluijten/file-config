<?php

namespace Sven\FileConfig\Tests;

use Sven\FileConfig\Json;

class JsonStoreTest extends TestCase
{
    /** @test */
    function it_reads_a_one_dimensional_json_file()
    {
        $this->create('one-dimensional.json', '{"ping": "pong"}');

        $config = new Json($this->file('one-dimensional.json'));

        $this->assertEquals('pong', $config->get('ping'));
    }

    /** @test */
    function it_reads_a_multi_dimensional_json_file()
    {
        $this->create('multi-dimensional.json', '{"ping": {"pong": "pang"}}');

        $config = new Json($this->file('multi-dimensional.json'));

        $this->assertEquals('pang', $config->get('ping.pong'));
        $this->assertEquals(['pong' => 'pang'], $config->get('ping'));
    }
}
