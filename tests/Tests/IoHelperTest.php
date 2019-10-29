<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\IoHelper;
use AndreasGlaser\Helpers\StringHelper;

/**
 * Class IoHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests
 */
class IoHelperTest extends BaseTest
{
    public function testCreateTmpDir()
    {
        $tmpDir = IoHelper::createTmpDir();

        $this->assertTrue(is_string($tmpDir));
        $this->assertTrue(is_dir($tmpDir));
        $this->assertTrue(is_readable($tmpDir));
        $this->assertTrue(is_writable($tmpDir));

        $this->assertTrue(StringHelper::startsWith(IoHelper::createTmpDir(null, null, true), sys_get_temp_dir()));
        $this->assertTrue(StringHelper::startsWith(IoHelper::createTmpDir(sys_get_temp_dir(), 'TEST_PREFIX', true), sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'TEST_PREFIX'));
    }

    public function testCreateTmpFile()
    {
        $tmpFile = IoHelper::createTmpFile();

        $this->assertTrue(is_string($tmpFile));
        $this->assertTrue(is_file($tmpFile));
        $this->assertTrue(is_readable($tmpFile));
        $this->assertTrue(is_writable($tmpFile));

        $this->assertTrue(StringHelper::startsWith(IoHelper::createTmpFile(null, null, true), sys_get_temp_dir()));
        $this->assertTrue(StringHelper::startsWith(IoHelper::createTmpFile(sys_get_temp_dir(), 'TEST_PREFIX', true), sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'TEST_PREFIX'));
    }

    public function testRmdirRecursive()
    {
        $tmpDir = IoHelper::createTmpDir();

        mkdir($tmpDir . DIRECTORY_SEPARATOR . 'test1');
        mkdir($tmpDir . DIRECTORY_SEPARATOR . 'test2');
        mkdir($tmpDir . DIRECTORY_SEPARATOR . 'test3');

        touch($tmpDir . DIRECTORY_SEPARATOR . 'test1' . DIRECTORY_SEPARATOR . 'file1');
        touch($tmpDir . DIRECTORY_SEPARATOR . 'test2' . DIRECTORY_SEPARATOR . 'file2');
        touch($tmpDir . DIRECTORY_SEPARATOR . 'test2' . DIRECTORY_SEPARATOR . 'file3');

        IoHelper::rmdirRecursive($tmpDir);
    }
}