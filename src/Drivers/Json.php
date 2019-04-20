<?php

namespace Sven\FileConfig\Drivers;

class Json implements Driver
{
    /**
     * {@inheritDoc}
     */
    public function import(string $contents): array
    {
        return json_decode($contents, true);
    }

    /**
     * {@inheritDoc}
     */
    public function export(array $config): string
    {
        return json_encode($config, JSON_FORCE_OBJECT | JSON_OBJECT_AS_ARRAY);
    }
}
