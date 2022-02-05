<?php

namespace Sven\FileConfig\Drivers;

class DotEnv implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function import(string $contents): array
    {
        $parts = explode(PHP_EOL, trim($contents, PHP_EOL));

        $result = [];

        foreach ($parts as $key => $part) {
            // [
            //     0 => 'FOO="bar"',
            //     1 => 'FOO',
            //     2 => '"',
            //     3 => 'bar',
            // ]
            preg_match('/(\w+)=([\"\']?)(.*)\2/', $part, $matches);

            if ($this->isEmptyLine($part) || $this->isComment($part)) {
                $result[$key] = $part;
            } else {
                $result[$matches[1]] = $matches[3];
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function export(array $config): string
    {
        $result = '';

        foreach ($config as $key => $value) {
            if ($this->isEmptyLine($value, $key)) {
                $result .= PHP_EOL;
            } elseif ($this->isComment($value)) {
                $result .= PHP_EOL.$value;
            } else {
                $result .= PHP_EOL.$key.'='.$this->quoteIfNecessary($value);
            }
        }

        return trim($result, PHP_EOL).PHP_EOL;
    }

    protected function isEmptyLine(string $value, $key = null): bool
    {
        return $value === '' && !is_string($key);
    }

    protected function isComment(string $value): bool
    {
        return str_starts_with($value, '#');
    }

    protected function quoteIfNecessary(string $value): string
    {
        // If the string contains anything that is not a
        // regular "word" like special characters or
        // spaces, we quote the value and return.
        if (preg_match('/[\W]/', $value) === 1) {
            return '"'.$value.'"';
        }

        return $value;
    }
}
