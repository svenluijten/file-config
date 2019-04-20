<?php

namespace Sven\FileConfig\Drivers;

class Env implements Driver
{
    /**
     * {@inheritDoc}
     */
    public function import(string $contents): array
    {
        $parts = explode("\n", $contents);

        $parts = array_filter($parts);

        foreach ($parts as $part) {
            preg_match('/([a-zA-Z_]+)\=(.+)/', $part, $regexResult);
            array_shift($regexResult);
            $result->push(new Collection($regexResult));
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function export(array $config): string
    {
        // TODO: Implement export() method.
    }
}
