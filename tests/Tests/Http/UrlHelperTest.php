<?php

namespace AndreasGlaser\Helpers\Tests\Http;

use AndreasGlaser\Helpers\Http\UrlHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * Class UrlHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests\Http
 */
class UrlHelperTest extends BaseTest
{
    /**
     */
    public function testProtocolHostPort()
    {
        $serverVars = $_SERVER;

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['HTTPS'] = 'off';

        $this->assertEquals('http://example.com', UrlHelper::protocolHostPort());

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '8080';
        $_SERVER['HTTPS'] = 'off';

        $this->assertEquals('http://example.com:8080', UrlHelper::protocolHostPort());

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '443';
        $_SERVER['HTTPS'] = 'on';

        $this->assertEquals('https://example.com', UrlHelper::protocolHostPort());

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '444';
        $_SERVER['HTTPS'] = 'on';

        $this->assertEquals('https://example.com:444', UrlHelper::protocolHostPort());

        $_SERVER = $serverVars;
    }

    /**
     */
    public function testQuery()
    {
        $this->assertEquals('?abc=test', UrlHelper::query(['abc' => 'test']));
        $this->assertNull(UrlHelper::query());

        $_GET['test'] = 'cheese';

        $this->assertEquals('?test=cheese', UrlHelper::query());
        $this->assertEquals('?test=cheese&test2=123', UrlHelper::query(['test2' => 123]));
        $this->assertEquals('?test2=123', UrlHelper::query(['test2' => 123], false));

        $_GET['sub']['test'] = 123;
        $_GET['sub']['blue'] = 5.8;

        $this->assertEquals('?test=cheese&sub%5Btest%5D=123&sub%5Bblue%5D=5.8', UrlHelper::query());
        $this->assertEquals('?test=cheese&sub%5Btest%5D=321&sub%5Bblue%5D=5.8', UrlHelper::query(['sub' => ['test' => 321]]));
        $this->assertEquals('?sub%5Btest%5D=321', UrlHelper::query(['sub' => ['test' => 321]], false));
    }

    /**
     */
    public function testCurrentUrl()
    {
        $serverVars = $_SERVER;

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['HTTPS'] = 'off';
        $_SERVER['REQUEST_URI'] = '/my-uri?abc=def';

        $this->assertEquals('http://example.com/my-uri?abc=def', UrlHelper::currentUrl());
        $this->assertEquals('http://example.com/my-uri', UrlHelper::currentUrl(false));
        $this->assertEquals('http%3A%2F%2Fexample.com%252Fmy-uri%253Fabc%253Ddef', UrlHelper::currentUrl(true, true));

        $_SERVER = $serverVars;
    }

    /**
     */
    public function testCurrentUri()
    {
        $serverVars = $_SERVER;

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/index.php/home?someVar=123';

        $this->assertEquals('/index.php/home?someVar=123', UrlHelper::currentUri());
        $this->assertEquals('/index.php/home', UrlHelper::currentUri(false));
        $this->assertEquals('%2Findex.php%2Fhome', UrlHelper::currentUri(false, true));

        $_SERVER = $serverVars;
    }
}