<?php

namespace Sven\FileConfig;

use Sven\FileConfig\Drivers\Driver;

class Store
{
    /** @var \Sven\FileConfig\File */
    protected $file;

    /** @var array */
    protected $config;

    /** @var \Sven\FileConfig\Drivers\Driver */
    protected $driver;

    public function __construct(File $file, Driver $driver)
    {
        $this->file = $file;
        $this->driver = $driver;
        $this->config = $driver->import($file->contents());
    }

    public function get($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }

    public function all(): array
    {
        return $this->config;
    }

    public function set($key, $value): void
    {
        Arr::set($this->config, $key, $value);
    }

    public function delete($key): void
    {
        Arr::forget($this->config, $key);
    }

    public function fresh(): Store
    {
        return new self($this->file, $this->driver);
    }

    public function persist(): bool
    {
        return $this->file->update(
            $this->driver->export($this->config)
        );
    }
}
