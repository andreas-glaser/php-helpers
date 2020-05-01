<?php

namespace AndreasGlaser\Helpers\Tests\Http;

use AndreasGlaser\Helpers\Http\RequestHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * Class RequestHelperTest.
 */
class RequestHelperTest extends BaseTest
{
    public function testIsCli()
    {
        self::assertTrue(RequestHelper::isCli());

        // mock request method
        $_SERVER['REQUEST_METHOD'] = 'GET';

        self::assertFalse(RequestHelper::isCli());
    }

    public function testIsHttps()
    {
        self::assertFalse(RequestHelper::isHttps());

        // mock server var
        $_SERVER['HTTPS'] = 'on';

        self::assertTrue(RequestHelper::isHttps());
    }
}
