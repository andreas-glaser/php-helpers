<?php

namespace AndreasGlaser\Helpers\Validate;

use AndreasGlaser\Helpers\Exceptions\IOException;
use AndreasGlaser\Helpers\StringHelper;
use AndreasGlaser\Helpers\ArrayHelper;

/**
 * IOExpect provides file system validation methods that throw exceptions on validation failures.
 * 
 * This class contains methods for validating file system paths:
 * - Directory existence and permissions
 * - File existence and permissions
 * - Read and write permissions
 * - Path existence and accessibility
 * - File size and type validation
 * - Directory emptiness checks
 * - Executable permissions
 * - Symbolic link validation
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

    /**
     * Validates that a path exists (file or directory).
     *
     * @param string $path The path to validate
     *
     * @throws IOException If the path does not exist
     */
    public static function exists(string $path): void
    {
        if (!\file_exists($path)) {
            throw new IOException(\sprintf('"%s" does not exist', $path), 0, null, $path);
        }
    }

    /**
     * Validates that a path is executable.
     *
     * @param string $path The path to validate
     *
     * @throws IOException If the path is not executable
     */
    public static function isExecutable(string $path): void
    {
        if (!\is_executable($path)) {
            throw new IOException(\sprintf('"%s" is not executable', $path), 0, null, $path);
        }
    }

    /**
     * Validates that a path is a symbolic link.
     *
     * @param string $path The path to validate
     *
     * @throws IOException If the path is not a symbolic link
     */
    public static function isLink(string $path): void
    {
        if (!\is_link($path)) {
            throw new IOException(\sprintf('"%s" is not a symbolic link', $path), 0, null, $path);
        }
    }

    /**
     * Validates that a directory is empty.
     *
     * @param string $path The directory path to validate
     *
     * @throws IOException If the path is not a directory or is not empty
     */
    public static function isDirEmpty(string $path): void
    {
        self::isDir($path);
        self::isReadable($path);

        $handle = \opendir($path);
        if (false === $handle) {
            throw new IOException(\sprintf('Cannot open directory "%s"', $path), 0, null, $path);
        }

        while (false !== ($entry = \readdir($handle))) {
            if (!StringHelper::isOneOf($entry, ['.', '..'])) {
                \closedir($handle);
                throw new IOException(\sprintf('Directory "%s" is not empty', $path), 0, null, $path);
            }
        }

        \closedir($handle);
    }

    /**
     * Validates that a directory is not empty.
     *
     * @param string $path The directory path to validate
     *
     * @throws IOException If the path is not a directory or is empty
     */
    public static function isDirNotEmpty(string $path): void
    {
        self::isDir($path);
        self::isReadable($path);

        $handle = \opendir($path);
        if (false === $handle) {
            throw new IOException(\sprintf('Cannot open directory "%s"', $path), 0, null, $path);
        }

        $isEmpty = true;
        while (false !== ($entry = \readdir($handle))) {
            if (!StringHelper::isOneOf($entry, ['.', '..'])) {
                $isEmpty = false;
                break;
            }
        }

        \closedir($handle);

        if ($isEmpty) {
            throw new IOException(\sprintf('Directory "%s" is empty', $path), 0, null, $path);
        }
    }

    /**
     * Validates that a file has a minimum size.
     *
     * @param string $path The file path to validate
     * @param int $minSize The minimum size in bytes
     *
     * @throws IOException If the file is smaller than the minimum size
     */
    public static function hasMinSize(string $path, int $minSize): void
    {
        self::isFile($path);
        self::isReadable($path);

        $size = \filesize($path);
        if (false === $size) {
            throw new IOException(\sprintf('Cannot determine size of file "%s"', $path), 0, null, $path);
        }

        if ($size < $minSize) {
            throw new IOException(\sprintf('File "%s" size (%d bytes) is smaller than required minimum (%d bytes)', $path, $size, $minSize), 0, null, $path);
        }
    }

    /**
     * Validates that a file has a maximum size.
     *
     * @param string $path The file path to validate
     * @param int $maxSize The maximum size in bytes
     *
     * @throws IOException If the file is larger than the maximum size
     */
    public static function hasMaxSize(string $path, int $maxSize): void
    {
        self::isFile($path);
        self::isReadable($path);

        $size = \filesize($path);
        if (false === $size) {
            throw new IOException(\sprintf('Cannot determine size of file "%s"', $path), 0, null, $path);
        }

        if ($size > $maxSize) {
            throw new IOException(\sprintf('File "%s" size (%d bytes) exceeds maximum allowed (%d bytes)', $path, $size, $maxSize), 0, null, $path);
        }
    }

    /**
     * Validates that a file has a specific extension.
     *
     * @param string $path The file path to validate
     * @param string $extension The expected extension (with or without leading dot)
     *
     * @throws IOException If the file does not have the expected extension
     */
    public static function hasExtension(string $path, string $extension): void
    {
        self::isFile($path);

        $extension = \ltrim($extension, '.');
        $actualExtension = \pathinfo($path, PATHINFO_EXTENSION);

        if (!StringHelper::is($actualExtension, $extension, false)) {
            throw new IOException(\sprintf('File "%s" does not have expected extension ".%s" (actual: ".%s")', $path, $extension, $actualExtension), 0, null, $path);
        }
    }

    /**
     * Validates that a file has one of the allowed extensions.
     *
     * @param string $path The file path to validate
     * @param array $extensions Array of allowed extensions (with or without leading dots)
     *
     * @throws IOException If the file does not have any of the allowed extensions
     */
    public static function hasAllowedExtension(string $path, array $extensions): void
    {
        self::isFile($path);

        $actualExtension = \pathinfo($path, PATHINFO_EXTENSION);
        $normalizedExtensions = \array_map(function($ext) {
            return \ltrim($ext, '.');
        }, $extensions);

        if (!StringHelper::isOneOf($actualExtension, $normalizedExtensions, false)) {
            $formattedExtensions = \array_map(function($ext) { return '.' . $ext; }, $normalizedExtensions);
            throw new IOException(\sprintf('File "%s" does not have an allowed extension (allowed: %s, actual: ".%s")', $path, \implode(', ', $formattedExtensions), $actualExtension), 0, null, $path);
        }
    }

    /**
     * Validates that a path does not exist.
     *
     * @param string $path The path to validate
     *
     * @throws IOException If the path already exists
     */
    public static function doesNotExist(string $path): void
    {
        if (\file_exists($path)) {
            throw new IOException(\sprintf('"%s" already exists', $path), 0, null, $path);
        }
    }

    /**
     * Validates that a parent directory exists and is writable.
     *
     * @param string $path The path whose parent directory to validate
     *
     * @throws IOException If the parent directory does not exist or is not writable
     */
    public static function parentDirWritable(string $path): void
    {
        $parentDir = \dirname($path);
        self::isDir($parentDir);
        self::isWritable($parentDir);
    }

    /**
     * Validates that a file is not empty.
     *
     * @param string $path The file path to validate
     *
     * @throws IOException If the file is empty
     */
    public static function isFileNotEmpty(string $path): void
    {
        self::isFile($path);
        self::isReadable($path);

        $size = \filesize($path);
        if (false === $size) {
            throw new IOException(\sprintf('Cannot determine size of file "%s"', $path), 0, null, $path);
        }

        if (0 === $size) {
            throw new IOException(\sprintf('File "%s" is empty', $path), 0, null, $path);
        }
    }

    /**
     * Validates that a file matches a specific MIME type.
     *
     * @param string $path The file path to validate
     * @param string $expectedMimeType The expected MIME type
     *
     * @throws IOException If the file does not match the expected MIME type or if MIME type cannot be determined
     */
    public static function hasMimeType(string $path, string $expectedMimeType): void
    {
        self::isFile($path);
        self::isReadable($path);

        if (!\function_exists('finfo_open')) {
            throw new IOException('fileinfo extension is required for MIME type validation', 0, null, $path);
        }

        $finfo = \finfo_open(FILEINFO_MIME_TYPE);
        if (false === $finfo) {
            throw new IOException('Cannot initialize fileinfo for MIME type detection', 0, null, $path);
        }

        $actualMimeType = \finfo_file($finfo, $path);
        \finfo_close($finfo);

        if (false === $actualMimeType) {
            throw new IOException(\sprintf('Cannot determine MIME type of file "%s"', $path), 0, null, $path);
        }

        if (!StringHelper::is($actualMimeType, $expectedMimeType, true)) {
            throw new IOException(\sprintf('File "%s" does not have expected MIME type "%s" (actual: "%s")', $path, $expectedMimeType, $actualMimeType), 0, null, $path);
        }
    }
}
