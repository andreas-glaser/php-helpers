<?php

namespace AndreasGlaser\Helpers;

use AndreasGlaser\Helpers\Exceptions\IOException;
use AndreasGlaser\Helpers\Validate\IOExpect;

/**
 * IOHelper provides utility methods for file and directory operations.
 * 
 * This class contains methods for:
 * - Creating temporary directories and files
 * - Recursive directory removal
 * - File system validation and error handling
 */
class IOHelper
{
    /**
     * Creates a temporary directory with specified options.
     *
     * @param string|null $destination The directory where the temporary directory should be created. If null, uses system temp directory.
     * @param string|null $prefix Optional prefix for the temporary directory name
     * @param bool $removeOnShutdown Whether to automatically remove the directory when the script ends
     *
     * @return string The path to the created temporary directory
     *
     * @throws IOException If the directory cannot be created or if the destination is not writable
     */
    public static function createTmpDir(string $destination = null, string $prefix = null, bool $removeOnShutdown = true): string
    {
        if (null === $destination) {
            $destination = \sys_get_temp_dir();
        }

        IOExpect::isDir($destination);
        IOExpect::isWritable($destination);

        $destinationFinal = $destination . DIRECTORY_SEPARATOR . \uniqid($prefix ?? '');

        if (false === \mkdir($destinationFinal, 0777, true)) {
            throw new IOException(\sprintf('Tmp dir "%s" could not be created', $destinationFinal), 0, null, $destinationFinal);
        }

        if (true === $removeOnShutdown) {
            \register_shutdown_function(function () use ($destinationFinal) {
                if (true === \is_dir($destinationFinal)) {
                    self::rmdirRecursive($destinationFinal);
                }
            });
        }

        IOExpect::isDir($destinationFinal);
        IOExpect::isReadable($destinationFinal);
        IOExpect::isWritable($destinationFinal);

        return $destinationFinal;
    }

    /**
     * Creates a temporary file with specified options.
     *
     * @param string|null $destination The directory where the temporary file should be created. If null, uses system temp directory.
     * @param string|null $prefix Optional prefix for the temporary file name
     * @param bool $removeOnShutdown Whether to automatically remove the file when the script ends
     *
     * @return string The path to the created temporary file
     *
     * @throws IOException If the file cannot be created or if the destination is not writable
     */
    public static function createTmpFile(string $destination = null, string $prefix = null, bool $removeOnShutdown = true): string
    {
        if (null === $destination) {
            $destination = \sys_get_temp_dir();
        }

        IOExpect::isDir($destination);
        IOExpect::isWritable($destination);

        $prefix = \uniqid($prefix ?? '');

        $filePath = \tempnam($destination, $prefix);

        if (true === $removeOnShutdown) {
            \register_shutdown_function(function () use ($filePath) {
                if (true === \is_file($filePath)) {
                    \unlink($filePath);
                }
            });
        }

        return $filePath;
    }

    /**
     * Recursively removes a directory and all its contents.
     *
     * @param string $dir The path to the directory to remove
     *
     * @throws IOException If the directory cannot be removed or if it's not readable/writable
     */
    public static function rmdirRecursive(string $dir): void
    {
        IOExpect::isDir($dir);
        IOExpect::isReadable($dir);
        IOExpect::isWritable($dir);

        $objects = \scandir($dir);

        foreach ($objects as $object) {
            if (true === StringHelper::isOneOf($object, ['.', '..'])) {
                continue;
            }

            $path = $dir . DIRECTORY_SEPARATOR . $object;

            if (true === \is_dir($path)) {
                self::rmdirRecursive($path);
            } else {
                \unlink($dir . DIRECTORY_SEPARATOR . $object);
            }
        }

        \rmdir($dir);
    }
}
