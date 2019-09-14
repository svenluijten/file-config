<?php

namespace Sven\FileConfig\Drivers;

class Env implements Driver
{
    const REGEX = '/([a-zA-Z0-9_]+)\=(.+)/';

    /**
     * {@inheritdoc}
     */
    public function import(string $contents): array
    {
        $parts = explode(PHP_EOL, trim($contents, PHP_EOL));

        $result = [];

        foreach ($parts as $part) {
            preg_match(self::REGEX, $part, $matches);

            if ($this->isEmptyLine($part) || $this->isComment($part)) {
                $result[] = [$part];
            } else {
                $result[] = [$matches[1] => $matches[2]];
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

        foreach ($config as $line) {
            foreach ($line as $key => $value) {
                if ($this->isEmptyLine($value)) {
                    $result .= PHP_EOL;
                } elseif ($this->isComment($value)) {
                    $result .= PHP_EOL.$value;
                } else {
                    $result .= PHP_EOL.$key.'='.$value;
                }
            }
        }

        return trim($result, PHP_EOL).PHP_EOL;
    }

    protected function isEmptyLine(string $value): bool
    {
        return $value === '';
    }

    protected function isComment(string $value): bool
    {
        return mb_substr($value, 0, 1) === '#';
    }
}
