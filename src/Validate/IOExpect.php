<?php

namespace AndreasGlaser\Helpers\Validate;

use AndreasGlaser\Helpers\Exceptions\IOException;

/**
 * Class IOExpect.
 */
class IOExpect
{
    public static function isDir(string $path)
    {
        if (!\is_dir($path)) {
            throw new IOException(\sprintf('"%s" is not a directory', $path), 0, null, $path);
        }
    }

    public static function isFile(string $path)
    {
        if (!\is_file($path)) {
            throw new IOException(\sprintf('"%s" is not a file', $path), 0, null, $path);
        }
    }

    public static function isReadable(string $path)
    {
        if (!\is_readable($path)) {
            throw new IOException(\sprintf('"%s" is not readable', $path), 0, null, $path);
        }
    }

    public static function isWritable(string $path)
    {
        if (!\is_writable($path)) {
            throw new IOException(\sprintf('"%s" is not writable', $path), 0, null, $path);
        }
    }
}
