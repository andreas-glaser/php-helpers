<?php

namespace AndreasGlaser\Helpers;

use AndreasGlaser\Helpers\Exceptions\IOException;
use AndreasGlaser\Helpers\Html\Ul\UnorderedListHelper;
use AndreasGlaser\Helpers\Validate\IOExpect;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class IOHelper
 *
 * @package AndreasGlaser\Helpers
 */
class IOHelper
{
    /**
     * @param string|null $destination
     * @param string|null $prefix
     * @param bool        $removeOnShutdown
     *
     * @return string
     */
    public static function createTmpDir(string $destination = null, string $prefix = null, bool $removeOnShutdown = true): string
    {
        if (null === $destination) {
            $destination = sys_get_temp_dir();
        }

        IOExpect::isDir($destination);
        IOExpect::isWritable($destination);

        $destinationFinal = $destination . DIRECTORY_SEPARATOR . uniqid($prefix);

        if (false === mkdir($destinationFinal, 0777, true)) {
            throw new IOException(sprintf('Tmp dir "%s" could not be created', $destinationFinal), 0, null, $destinationFinal);
        }

        if (true === $removeOnShutdown) {
            register_shutdown_function(function () use ($destinationFinal) {
                if (true === is_dir($destinationFinal)) {
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
     * @param string|null $destination
     * @param string|null $prefix
     * @param bool        $removeOnShutdown
     *
     * @return string
     */
    public static function createTmpFile(string $destination = null, string $prefix = null, bool $removeOnShutdown = true): string
    {
        if (null === $destination) {
            $destination = sys_get_temp_dir();
        }

        IOExpect::isDir($destination);
        IOExpect::isWritable($destination);

        $prefix = uniqid($prefix);

        $filePath = tempnam($destination, $prefix);;

        if (true === $removeOnShutdown) {
            register_shutdown_function(function () use ($filePath) {
                if (true === is_file($filePath)) {
                    unlink($filePath);
                }
            });
        }

        return $filePath;
    }

    /**
     * @param string $dir
     *
     * @return void
     */
    public static function rmdirRecursive(string $dir)
    {
        IOExpect::isDir($dir);
        IOExpect::isReadable($dir);
        IOExpect::isWritable($dir);

        $objects = scandir($dir);

        foreach ($objects as $object) {
            if (true === StringHelper::isOneOf($object, ['.', '..'])) {
                continue;
            }

            $path = $dir . DIRECTORY_SEPARATOR . $object;

            if (true === is_dir($path)) {
                self::rmdirRecursive($path);
            } else {
                unlink($dir . DIRECTORY_SEPARATOR . $object);
            }
        }

        rmdir($dir);
    }
}