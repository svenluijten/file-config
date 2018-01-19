<?php

namespace Sven\FileConfig\Tests;

use Sven\FileConfig\Json;

class JsonStoreTest extends TestCase
{
    /** @test */
    public function it_reads_a_one_dimensional_json_file()
    {
        $this->create('one-dimensional.json', '{"ping":"pong"}');

        $config = new Json($this->file('one-dimensional.json'));

        $this->assertEquals('pong', $config->get('ping'));
    }

    /** @test */
    public function it_reads_a_multi_dimensional_json_file()
    {
        $this->create('multi-dimensional.json', '{"ping":{"pong":"pang"}}');

        $config = new Json($this->file('multi-dimensional.json'));

        $this->assertEquals('pang', $config->get('ping.pong'));
        $this->assertEquals(['pong' => 'pang'], $config->get('ping'));
    }

    /** @test */
    public function it_sets_a_config_value()
    {
        $this->create('set.json', '{"ping":"pong"}');

        $config = new Json($this->file('set.json'));
        $config->set('ping', 'pang');

        $this->assertEquals('pang', $config->get('ping'));
        $this->assertEquals('{"ping":"pang"}', $this->file('set.json')->read());

        $config->set('foo', 'bar');
        $this->assertEquals('bar', $config->get('foo'));
        $this->assertEquals('{"ping":"pang","foo":"bar"}', $this->file('set.json')->read());
    }

    /** @test */
    public function it_deletes_a_config_value()
    {
        $this->create('delete.json', '{"ping","pong"}');

        $config = new Json($this->file('delete.json'));

        $this->assertTrue($config->delete('ping'));
        $this->assertEquals('{}', $this->file('delete.json')->read());
    }

    /** @test */
    public function it_deletes_a_nested_value()
    {
        $this->create('delete-nested.json', '{"ping":{"pong":{"foo":"bar"}}}');

        $config = new Json($this->file('delete-nested.json'));

        $this->assertTrue($config->delete('ping.pong'));
        $this->assertEquals('{"ping":{}}', $this->file('delete-nested.json')->read());
    }
}
