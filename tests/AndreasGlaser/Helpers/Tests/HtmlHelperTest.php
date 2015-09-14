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
    /**
     * @var \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    protected $testAttributes;

    public function __construct()
    {
        $this->testAttributes = new AttributesHelper();
        $this->testAttributes->setId('MY_ID');
        $this->testAttributes->addClass('cheese');
        $this->testAttributes->addClass('car');
        $this->testAttributes->addData('something', 'XYZ ');
    }

    /**
     * @author Andreas Glaser
     */
    public function testDiv()
    {
        $this->assertEquals(
            '<div id="MY_ID" class="cheese car" data-something="XYZ ">Some Nice Content</div>',
            HtmlHelper::div('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testP()
    {
        $this->assertEquals(
            '<p id="MY_ID" class="cheese car" data-something="XYZ ">Some Nice Content</p>',
            HtmlHelper::p('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testSpan()
    {
        $this->assertEquals(
            '<span id="MY_ID" class="cheese car" data-something="XYZ ">Some Nice Content</span>',
            HtmlHelper::span('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testH1()
    {
        $this->assertEquals(
            '<h1 id="MY_ID" class="cheese car" data-something="XYZ ">Some Nice Content</h1>',
            HtmlHelper::h1('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testH2()
    {
        $this->assertEquals(
            '<h2 id="MY_ID" class="cheese car" data-something="XYZ ">Some Nice Content</h2>',
            HtmlHelper::h2('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testH3()
    {
        $this->assertEquals(
            '<h3 id="MY_ID" class="cheese car" data-something="XYZ ">Some Nice Content</h3>',
            HtmlHelper::h3('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testH4()
    {
        $this->assertEquals(
            '<h4 id="MY_ID" class="cheese car" data-something="XYZ ">Some Nice Content</h4>',
            HtmlHelper::h4('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testH5()
    {
        $this->assertEquals(
            '<h5 id="MY_ID" class="cheese car" data-something="XYZ ">Some Nice Content</h5>',
            HtmlHelper::h5('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testH6()
    {
        $this->assertEquals(
            '<h6 id="MY_ID" class="cheese car" data-something="XYZ ">Some Nice Content</h6>',
            HtmlHelper::h6('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testA()
    {
        $this->assertEquals(
            '<a id="MY_ID" class="cheese car" href="/my-url/test" data-something="XYZ " >Some Nice Content</a>',
            HtmlHelper::a('/my-url/test', 'Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testImage()
    {
        $this->assertEquals(
            '<img id="MY_ID" class="cheese car" src="/my-url/test.png" data-something="XYZ " />',
            HtmlHelper::image('/my-url/test.png', $this->testAttributes)
        );
    }
}