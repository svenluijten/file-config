<?php

namespace Sven\FileConfig\Stores;

use Sven\FileConfig\File;

interface Store
{
    /**
     * Initialize the configuration storage.
     *
     * @param \Sven\FileConfig\File $file
     */
    public function __construct(File $file);

    /**
     * Retrieve the configuration value.
     *
     * @param int|string $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * Set or update a configuration value.
     *
     * @param int|string $key
     * @param mixed      $value
     *
     * @return bool
     */
    public function set($key, $value): bool;

    /**
     * Entirely remove a configuration value.
     *
     * @param int|string $key
     *
     * @return bool
     */
    public function delete($key): bool;
}
