<?php

namespace AndreasGlaser\Helpers\Tests\Http;

use AndreasGlaser\Helpers\Http\RequestHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * Class RequestHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests\Http
 * @author  Andreas Glaser
 */
class RequestHelperTest extends BaseTest
{
    /**
     * @author Andreas Glaser
     */
    public function testIsCli()
    {
        $this->assertTrue(RequestHelper::isCli());

        // mock request method
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->assertFalse(RequestHelper::isCli());
    }

    /**
     * @author Andreas Glaser
     */
    public function testIsHttps()
    {
        $this->assertFalse(RequestHelper::isHttps());

        // mock server var
        $_SERVER['HTTPS'] = 'on';

        $this->assertTrue(RequestHelper::isHttps());
    }
}