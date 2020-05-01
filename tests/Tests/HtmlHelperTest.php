<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\HtmlHelper;

/**
 * Class HtmlHelperTest.
 */
class HtmlHelperTest extends BaseTest
{
    /**
     * @var \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    protected $testAttributes;

    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->testAttributes = new AttributesHelper(['class' => 'horseradish']);
        $this->testAttributes->setId('CHESTNUT');
        $this->testAttributes->addClass('cheese');
        $this->testAttributes->addClass('peanuts');
        $this->testAttributes->addData('beef-steak', 'XYZ ');
    }

    public function testDiv()
    {
        self::assertEquals(
            '<div id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</div>',
            HtmlHelper::div('Some Nice Content', $this->testAttributes)
        );
    }

    public function testP()
    {
        self::assertEquals(
            '<p id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</p>',
            HtmlHelper::p('Some Nice Content', $this->testAttributes)
        );
    }

    public function testSpan()
    {
        self::assertEquals(
            '<span id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</span>',
            HtmlHelper::span('Some Nice Content', $this->testAttributes)
        );
    }

    public function testH1()
    {
        self::assertEquals(
            '<h1 id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</h1>',
            HtmlHelper::h1('Some Nice Content', $this->testAttributes)
        );
    }

    public function testH2()
    {
        self::assertEquals(
            '<h2 id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</h2>',
            HtmlHelper::h2('Some Nice Content', $this->testAttributes)
        );
    }

    public function testH3()
    {
        self::assertEquals(
            '<h3 id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</h3>',
            HtmlHelper::h3('Some Nice Content', $this->testAttributes)
        );
    }

    public function testH4()
    {
        self::assertEquals(
            '<h4 id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</h4>',
            HtmlHelper::h4('Some Nice Content', $this->testAttributes)
        );
    }

    public function testH5()
    {
        self::assertEquals(
            '<h5 id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</h5>',
            HtmlHelper::h5('Some Nice Content', $this->testAttributes)
        );
    }

    public function testH6()
    {
        self::assertEquals(
            '<h6 id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</h6>',
            HtmlHelper::h6('Some Nice Content', $this->testAttributes)
        );
    }

    public function testA()
    {
        self::assertEquals(
            '<a id="CHESTNUT" class="horseradish cheese peanuts" href="/my-url/test" data-beef-steak="XYZ " >Some Nice Content</a>',
            HtmlHelper::a('/my-url/test', 'Some Nice Content', $this->testAttributes)
        );
    }

    public function testImage()
    {
        self::assertEquals(
            '<img id="CHESTNUT" class="horseradish cheese peanuts" src="/my-url/test.png" data-beef-steak="XYZ " />',
            HtmlHelper::image('/my-url/test.png', $this->testAttributes)
        );
    }
}
