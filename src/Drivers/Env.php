<?php

namespace Sven\FileConfig\Drivers;

/**
 * @deprecated
 */
class Env implements Driver
{
    const REGEX = '/([a-zA-Z0-9_]+)\=(.+)?/';

    /**
     * {@inheritdoc}
     */
    public function import(string $contents): array
    {
        $parts = explode(PHP_EOL, trim($contents, PHP_EOL));

        $result = [];

        foreach ($parts as $key => $part) {
            preg_match(self::REGEX, $part, $matches);

            if ($this->isEmptyLine($part) || $this->isComment($part)) {
                $result[$key] = $part;
            } else {
                $result[$matches[1]] = $matches[2] ?? '';
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
                $result .= PHP_EOL.$key.'='.$value;
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
        return mb_substr($value, 0, 1) === '#';
    }
}
