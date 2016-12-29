<?php

namespace AndreasGlaser\Helpers\Tests\Http;

use AndreasGlaser\Helpers\Http\UrlHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * Class UrlHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests\Http
 * @author  Andreas Glaser
 */
class UrlHelperTest extends BaseTest
{
    /**
     * @author Andreas Glaser
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
     * @author Andreas Glaser
     */
    public function testCurrentUrl()
    {
        // todo
    }

    /**
     * @author Andreas Glaser
     */
    public function testCurrentUri()
    {
        // todo
    }
}