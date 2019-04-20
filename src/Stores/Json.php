<?php

namespace Sven\FileConfig\Stores;

use Sven\FileConfig\Arr;
use Sven\FileConfig\File;

class Json implements Store
{
    /**
     * @var \Sven\FileConfig\File
     */
    protected $file;

    /**
     * @var array
     */
    protected $config;

    /**
     * {@inheritdoc}
     */
    public function __construct(File $file)
    {
        $this->file = $file;
        $this->config = json_decode($file->contents(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value): bool
    {
        Arr::set($this->config, $key, $value);

        return $this->persist();
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key): bool
    {
        Arr::forget($this->config, $key);

        return $this->persist();
    }

    /**
     * @return bool
     */
    protected function persist(): bool
    {
        return $this->file->update(
            json_encode($this->config, JSON_FORCE_OBJECT | JSON_OBJECT_AS_ARRAY)
        );
    }
}
