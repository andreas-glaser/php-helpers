<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\IOHelper;
use AndreasGlaser\Helpers\StringHelper;

/**
 * Class IOHelperTest.
 */
class IOHelperTest extends BaseTest
{
    public function testCreateTmpDir()
    {
        $tmpDir = IOHelper::createTmpDir();

        self::assertTrue(\is_string($tmpDir));
        self::assertTrue(\is_dir($tmpDir));
        self::assertTrue(\is_readable($tmpDir));
        self::assertTrue(\is_writable($tmpDir));

        self::assertTrue(StringHelper::startsWith(IOHelper::createTmpDir(null, null, true), \sys_get_temp_dir()));
        self::assertTrue(StringHelper::startsWith(IOHelper::createTmpDir(\sys_get_temp_dir(), 'TEST_PREFIX', true), \sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'TEST_PREFIX'));
    }

    public function testCreateTmpFile()
    {
        $tmpFile = IOHelper::createTmpFile();

        self::assertTrue(\is_string($tmpFile));
        self::assertTrue(\is_file($tmpFile));
        self::assertTrue(\is_readable($tmpFile));
        self::assertTrue(\is_writable($tmpFile));

        self::assertTrue(StringHelper::startsWith(IOHelper::createTmpFile(null, null, true), \sys_get_temp_dir()));
        self::assertTrue(StringHelper::startsWith(IOHelper::createTmpFile(\sys_get_temp_dir(), 'TEST_PREFIX', true), \sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'TEST_PREFIX'));
    }

    public function testRmdirRecursive()
    {
        $tmpDir = IOHelper::createTmpDir();

        \mkdir($tmpDir . DIRECTORY_SEPARATOR . 'test1');
        \mkdir($tmpDir . DIRECTORY_SEPARATOR . 'test2');
        \mkdir($tmpDir . DIRECTORY_SEPARATOR . 'test3');

        \touch($tmpDir . DIRECTORY_SEPARATOR . 'test1' . DIRECTORY_SEPARATOR . 'file1');
        \touch($tmpDir . DIRECTORY_SEPARATOR . 'test2' . DIRECTORY_SEPARATOR . 'file2');
        \touch($tmpDir . DIRECTORY_SEPARATOR . 'test2' . DIRECTORY_SEPARATOR . 'file3');

        IOHelper::rmdirRecursive($tmpDir);
    }
}
