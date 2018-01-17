<?php

namespace Sven\FileConfig;

use Dflydev\DotAccessData\Data;
use League\Flysystem\File;

class Json implements Store
{
    /**
     * @var string
     */
    protected $file;

    /**
     * {@inheritdoc}
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        $contents = json_decode($this->file->read(), true);

        return (new Data($contents))->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value): bool
    {
        // TODO: Implement set() method.
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key): bool
    {
        // TODO: Implement delete() method.
    }
}
