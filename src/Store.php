<?php

namespace Sven\FileConfig;

use Sven\FileConfig\Drivers\Driver;

class Store
{
    protected array $config;
    protected File $file;

    public function __construct(string|File $file, protected Driver $driver)
    {
        $this->file = is_string($file) ? new File($file) : $file;

        $this->config = $driver->import($this->file->contents());
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
