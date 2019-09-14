<?php

namespace Sven\FileConfig\Drivers;

class Json implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function import(string $contents): array
    {
        return json_decode($contents, true);
    }

    /**
     * {@inheritdoc}
     */
    public function export(array $config): string
    {
        return json_encode($config, JSON_FORCE_OBJECT | JSON_OBJECT_AS_ARRAY);
    }
}
