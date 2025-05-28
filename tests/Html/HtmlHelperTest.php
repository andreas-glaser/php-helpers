<?php

namespace AndreasGlaser\Helpers\Tests\Html;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\HtmlHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * HtmlHelperTest provides unit tests for the HtmlHelper class.
 *
 * This class tests HTML element generation:
 * - Basic elements (div, p, span)
 * - Heading elements (h1-h6)
 * - Links and images
 * - HTML attributes handling
 */
class HtmlHelperTest extends BaseTest
{
    /**
     * @var \AndreasGlaser\Helpers\Html\AttributesHelper Test attributes for HTML elements
     */
    protected $testAttributes;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testAttributes = new AttributesHelper(['class' => 'horseradish']);
        $this->testAttributes->setId('CHESTNUT');
        $this->testAttributes->addClass('cheese');
        $this->testAttributes->addClass('peanuts');
        $this->testAttributes->addData('beef-steak', 'XYZ ');
    }

    /**
     * Tests generating a div element with attributes.
     * Verifies that the div element is properly generated with all specified attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::div
     * @return void
     */
    public function testDiv()
    {
        self::assertEquals(
            '<div id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</div>',
            HtmlHelper::div('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * Tests generating a paragraph element with attributes.
     * Verifies that the p element is properly generated with all specified attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::p
     * @return void
     */
    public function testP()
    {
        self::assertEquals(
            '<p id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</p>',
            HtmlHelper::p('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * Tests generating a span element with attributes.
     * Verifies that the span element is properly generated with all specified attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::span
     * @return void
     */
    public function testSpan()
    {
        self::assertEquals(
            '<span id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</span>',
            HtmlHelper::span('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * Tests generating an h1 element with attributes.
     * Verifies that the h1 element is properly generated with all specified attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::h1
     * @return void
     */
    public function testH1()
    {
        self::assertEquals(
            '<h1 id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</h1>',
            HtmlHelper::h1('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * Tests generating an h2 element with attributes.
     * Verifies that the h2 element is properly generated with all specified attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::h2
     * @return void
     */
    public function testH2()
    {
        self::assertEquals(
            '<h2 id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</h2>',
            HtmlHelper::h2('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * Tests generating an h3 element with attributes.
     * Verifies that the h3 element is properly generated with all specified attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::h3
     * @return void
     */
    public function testH3()
    {
        self::assertEquals(
            '<h3 id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</h3>',
            HtmlHelper::h3('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * Tests generating an h4 element with attributes.
     * Verifies that the h4 element is properly generated with all specified attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::h4
     * @return void
     */
    public function testH4()
    {
        self::assertEquals(
            '<h4 id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</h4>',
            HtmlHelper::h4('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * Tests generating an h5 element with attributes.
     * Verifies that the h5 element is properly generated with all specified attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::h5
     * @return void
     */
    public function testH5()
    {
        self::assertEquals(
            '<h5 id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</h5>',
            HtmlHelper::h5('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * Tests generating an h6 element with attributes.
     * Verifies that the h6 element is properly generated with all specified attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::h6
     * @return void
     */
    public function testH6()
    {
        self::assertEquals(
            '<h6 id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Some Nice Content</h6>',
            HtmlHelper::h6('Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * Tests generating an anchor element with attributes.
     * Verifies that the a element is properly generated with href and all specified attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::a
     * @return void
     */
    public function testA()
    {
        self::assertEquals(
            '<a id="CHESTNUT" class="horseradish cheese peanuts" href="/my-url/test" data-beef-steak="XYZ " >Some Nice Content</a>',
            HtmlHelper::a('/my-url/test', 'Some Nice Content', $this->testAttributes)
        );
    }

    /**
     * Tests generating an image element with attributes.
     * Verifies that the img element is properly generated with src and all specified attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::image
     * @return void
     */
    public function testImage()
    {
        self::assertEquals(
            '<img id="CHESTNUT" class="horseradish cheese peanuts" src="/my-url/test.png" data-beef-steak="XYZ " />',
            HtmlHelper::image('/my-url/test.png', $this->testAttributes)
        );
    }
}
