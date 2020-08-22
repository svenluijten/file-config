<?php

namespace Sven\FileConfig;

class File
{
    /** @var string */
    protected $path;

    public function __construct(string $path)
    {
        if (!is_file($path)) {
            throw new \RuntimeException('File not found at "'.$path.'".');
        }

        $this->path = $path;
    }

    public function contents(): string
    {
        return file_get_contents($this->path);
    }

    public function update(string $content): bool
    {
        return (bool) file_put_contents($this->path, $content);
    }
}
