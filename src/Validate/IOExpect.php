<?php

namespace AndreasGlaser\Helpers\Validate;

use AndreasGlaser\Helpers\Exceptions\IOException;

/**
 * IOExpect provides file system validation methods that throw exceptions on validation failures.
 * 
 * This class contains methods for validating file system paths:
 * - Directory existence and permissions
 * - File existence and permissions
 * - Read and write permissions
 * 
 * Each method throws IOException if the validation fails.
 */
class IOExpect
{
    /**
     * Validates that a path exists and is a directory.
     *
     * @param string $path The path to validate
     *
     * @throws IOException If the path is not a directory
     */
    public static function isDir(string $path): void
    {
        if (!\is_dir($path)) {
            throw new IOException(\sprintf('"%s" is not a directory', $path), 0, null, $path);
        }
    }

    /**
     * Validates that a path exists and is a file.
     *
     * @param string $path The path to validate
     *
     * @throws IOException If the path is not a file
     */
    public static function isFile(string $path): void
    {
        if (!\is_file($path)) {
            throw new IOException(\sprintf('"%s" is not a file', $path), 0, null, $path);
        }
    }

    /**
     * Validates that a path is readable.
     *
     * @param string $path The path to validate
     *
     * @throws IOException If the path is not readable
     */
    public static function isReadable(string $path): void
    {
        if (!\is_readable($path)) {
            throw new IOException(\sprintf('"%s" is not readable', $path), 0, null, $path);
        }
    }

    /**
     * Validates that a path is writable.
     *
     * @param string $path The path to validate
     *
     * @throws IOException If the path is not writable
     */
    public static function isWritable(string $path): void
    {
        if (!\is_writable($path)) {
            throw new IOException(\sprintf('"%s" is not writable', $path), 0, null, $path);
        }
    }
}
