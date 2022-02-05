<?php

namespace Sven\FileConfig\Drivers;

class Json implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function import(string $contents): array
    {
        return json_decode($contents, associative: true, flags: JSON_THROW_ON_ERROR);
    }

    /**
     * {@inheritdoc}
     */
    public function export(array $config): string
    {
        return json_encode($config, flags: JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT | JSON_OBJECT_AS_ARRAY);
    }
}
