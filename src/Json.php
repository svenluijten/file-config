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
     * @var \Dflydev\DotAccessData\Data
     */
    protected $config;

    /**
     * {@inheritdoc}
     */
    public function __construct(File $file)
    {
        $this->file = $file;
        $this->config = new Data(json_decode($file->read(), true));
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $this->config->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value): bool
    {
        $this->config->set($key, $value);

        return $this->persist();
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key): bool
    {
        $this->config->remove($key);

        return $this->persist();
    }

    /**
     * @return bool
     */
    protected function persist(): bool
    {
        $values = $this->config->export();

        return $this->file->update(
            json_encode($values, JSON_FORCE_OBJECT | JSON_OBJECT_AS_ARRAY)
        );
    }
}
