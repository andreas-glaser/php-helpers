<?php

namespace AndreasGlaser\Helpers\Tests\Validate;

use AndreasGlaser\Helpers\Exceptions\IOException;
use AndreasGlaser\Helpers\Tests\BaseTest;
use AndreasGlaser\Helpers\Validate\IOExpect;

/**
 * Class IOExpectTest.
 */
class IOExpectTest extends BaseTest
{
    public function testIsDir()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage(\sprintf('"%s" is not a directory', __FILE__));

        IOExpect::isDir(__FILE__);
    }

    public function testIsFile()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage(\sprintf('"%s" is not a file', __DIR__));

        IOExpect::isFile(__DIR__);
    }

    public function testIsReadable()
    {
        // todo
    }

    public function testIsWritable()
    {
        // todo
    }
}
