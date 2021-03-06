<?php

namespace Sven\FileConfig\Tests;

use Sven\FileConfig\Drivers\Json;
use Sven\FileConfig\File;
use Sven\FileConfig\Store;

class StoreTest extends TestCase
{
    /** @test */
    public function it_can_get_and_set_values(): void
    {
        $this->create('test.json', '{"foo":"bar"}');

        $file = new File(__DIR__.'/'.self::TEMP_DIRECTORY.'/test.json');
        $store = new Store($file, new Json());

        $this->assertEquals('bar', $store->get('foo'));
        $store->set('foo', 'something else');
        $this->assertEquals('something else', $store->get('foo'));

        $contents = function () {
            return file_get_contents(__DIR__.'/'.self::TEMP_DIRECTORY.'/test.json');
        };

        $this->assertStringNotContainsString('something else', $contents());
        $store->persist();
        $this->assertStringContainsString('something else', $contents());
    }

    /** @test */
    public function it_falls_back_to_the_default_if_a_key_does_not_exist(): void
    {
        $this->create('test.json', '{"foo":"bar"}');

        $file = new File(__DIR__.'/'.self::TEMP_DIRECTORY.'/test.json');
        $store = new Store($file, new Json());

        $this->assertNull($store->get('non_existing_key'));
        $this->assertEquals('default', $store->get('non_existing_key', 'default'));
    }

    /** @test */
    public function it_can_delete_values(): void
    {
        $this->create('test.json', '{"foo":"bar","abc":"def"}');

        $file = new File(__DIR__.'/'.self::TEMP_DIRECTORY.'/test.json');
        $store = new Store($file, new Json());

        $store->delete('abc');

        $contents = function () {
            return file_get_contents(__DIR__.'/'.self::TEMP_DIRECTORY.'/test.json');
        };

        $this->assertStringContainsString('abc', $contents());

        $store->persist();

        $this->assertStringNotContainsString('abc', $contents());
    }

    /** @test */
    public function it_can_get_a_fresh_instance_of_the_configuration_object(): void
    {
        $this->create('test.json', '{"foo":"bar","abc":"def"}');

        $file = new File(__DIR__.'/'.self::TEMP_DIRECTORY.'/test.json');
        $store = new Store($file, new Json());

        $store->set('foo', 'something else');
        $store->delete('abc');

        $newStore = $store->fresh();

        $this->assertEquals('something else', $store->get('foo'));
        $this->assertNotEquals('something else', $newStore->get('foo'));
        $this->assertNull($store->get('abc'));
        $this->assertEquals('def', $newStore->get('abc'));
    }

    /** @test */
    public function it_can_get_all_values_from_the_config(): void
    {
        $this->create('test.json', '{"foo":"bar","abc":"def"}');

        $file = new File(__DIR__.'/'.self::TEMP_DIRECTORY.'/test.json');
        $store = new Store($file, new Json());

        $values = $store->all();

        $this->assertArrayHasKey('foo', $values);
        $this->assertArrayHasKey('abc', $values);
        $this->assertEquals('bar', $values['foo']);
        $this->assertEquals('def', $values['abc']);
    }
}
