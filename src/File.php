<?php

namespace Sven\FileConfig;

use League\Flysystem\Adapter\Local;
use League\Flysystem\File as FilesystemFile;
use League\Flysystem\Filesystem;

class File
{
    /**
     * @var \League\Flysystem\File
     */
    protected $file;

    /**
     * File constructor.
     *
     * @param string $path
     *
     * @throws \LogicException
     */
    public function __construct(string $path)
    {
        ['root' => $root, 'file' => $file] = $this->parsePath($path);

        $this->file = new FilesystemFile(
            $this->filesystem($root), $file
        );
    }

    /**
     * @return string
     */
    public function contents(): string
    {
        return $this->file->read();
    }

    /**
     * @param string $content
     *
     * @return bool
     */
    public function update($content): bool
    {
        return $this->file->update($content);
    }

    /**
     * @param string $root
     *
     * @throws \LogicException
     *
     * @return \League\Flysystem\Filesystem
     */
    protected function filesystem(string $root): Filesystem
    {
        $adapter = new Local($root);

        return new Filesystem($adapter);
    }

    /**
     * @param string $path
     *
     * @return array
     */
    protected function parsePath(string $path): array
    {
        $parts = explode(DIRECTORY_SEPARATOR, $path);

        $file = array_pop($parts);

        return [
            'root' => implode(DIRECTORY_SEPARATOR, $parts),
            'file' => $file,
        ];
    }
}
