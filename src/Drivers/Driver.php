<?php

namespace Sven\FileConfig\Drivers;

interface Driver
{
    /**
     * Convert the file format to a PHP array.
     */
    public function import(string $contents): array;

    /**
     * Convert the PHP array back to the right format.
     */
    public function export(array $config): string;
}
