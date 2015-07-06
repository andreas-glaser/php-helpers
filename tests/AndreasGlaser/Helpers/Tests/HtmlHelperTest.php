<?php

namespace AndreasGlaser\Helpers\Test;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\HtmlHelper;
use AndreasGlaser\Helpers\StringHelper;

/**
 * Class HtmlHelperTest
 *
 * @package Helpers\Test
 *
 * @author  Andreas Glaser
 */
class HtmlHelperTest extends \PHPUnit_Framework_TestCase
{

    public function testP()
    {
        $this->assertTrue(StringHelper::is(HtmlHelper::p('Hello'), '<p>Hello</p>'));
        $this->assertTrue(StringHelper::is(HtmlHelper::p('Hello', AttributesHelper::create(['id' => 'abc'])), '<p id="abc">Hello</p>'));
    }
}