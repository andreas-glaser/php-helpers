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

    /**
     * Tests generating a strong element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::strong
     * @return void
     */
    public function testStrong()
    {
        self::assertEquals(
            '<strong id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Bold Text</strong>',
            HtmlHelper::strong('Bold Text', $this->testAttributes)
        );
    }

    /**
     * Tests generating an em element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::em
     * @return void
     */
    public function testEm()
    {
        self::assertEquals(
            '<em id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Emphasized Text</em>',
            HtmlHelper::em('Emphasized Text', $this->testAttributes)
        );
    }

    /**
     * Tests generating a code element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::code
     * @return void
     */
    public function testCode()
    {
        self::assertEquals(
            '<code id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">$var = "test";</code>',
            HtmlHelper::code('$var = "test";', $this->testAttributes)
        );
    }

    /**
     * Tests generating a pre element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::pre
     * @return void
     */
    public function testPre()
    {
        $content = "function test() {\n    return true;\n}";
        $result = HtmlHelper::pre($content, $this->testAttributes);
        
        // Test that the result contains all the expected attributes
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        
        // Test that the content is preserved exactly
        self::assertStringContainsString($content, $result);
        
        // Test the element structure
        self::assertStringStartsWith('<pre', $result);
        self::assertStringEndsWith('</pre>', $result);
    }

    /**
     * Tests generating a blockquote element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::blockquote
     * @return void
     */
    public function testBlockquote()
    {
        self::assertEquals(
            '<blockquote id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">To be or not to be</blockquote>',
            HtmlHelper::blockquote('To be or not to be', $this->testAttributes)
        );
    }

    /**
     * Tests generating a cite element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::cite
     * @return void
     */
    public function testCite()
    {
        self::assertEquals(
            '<cite id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Shakespeare</cite>',
            HtmlHelper::cite('Shakespeare', $this->testAttributes)
        );
    }

    /**
     * Tests generating a mark element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::mark
     * @return void
     */
    public function testMark()
    {
        self::assertEquals(
            '<mark id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Highlighted Text</mark>',
            HtmlHelper::mark('Highlighted Text', $this->testAttributes)
        );
    }

    /**
     * Tests generating a time element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::time
     * @return void
     */
    public function testTime()
    {
        $attributes = clone $this->testAttributes;
        $result = HtmlHelper::time('March 20, 2024', '2024-03-20', $attributes);
        
        // Test that the result contains all the expected attributes
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('datetime="2024-03-20"', $result);
        
        // Test the content
        self::assertStringContainsString('March 20, 2024', $result);
        
        // Test the element structure
        self::assertStringStartsWith('<time', $result);
        self::assertStringEndsWith('</time>', $result);
    }

    /**
     * Tests generating a small element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::small
     * @return void
     */
    public function testSmall()
    {
        self::assertEquals(
            '<small id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">Small Text</small>',
            HtmlHelper::small('Small Text', $this->testAttributes)
        );
    }

    /**
     * Tests generating a sub element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::sub
     * @return void
     */
    public function testSub()
    {
        self::assertEquals(
            '<sub id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">2</sub>',
            HtmlHelper::sub('2', $this->testAttributes)
        );
    }

    /**
     * Tests generating a sup element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::sup
     * @return void
     */
    public function testSup()
    {
        self::assertEquals(
            '<sup id="CHESTNUT" class="horseradish cheese peanuts" data-beef-steak="XYZ ">2</sup>',
            HtmlHelper::sup('2', $this->testAttributes)
        );
    }

    /**
     * Tests generating an abbr element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::abbr
     * @return void
     */
    public function testAbbr()
    {
        $attributes = clone $this->testAttributes;
        $result = HtmlHelper::abbr('WHO', 'World Health Organization', $attributes);
        
        // Test that the result contains all the expected attributes
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('title="World Health Organization"', $result);
        
        // Test the content
        self::assertStringContainsString('>WHO<', $result);
        
        // Test the element structure
        self::assertStringStartsWith('<abbr', $result);
        self::assertStringEndsWith('</abbr>', $result);
    }

    /**
     * Tests generating an article element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::article
     * @return void
     */
    public function testArticle()
    {
        $result = HtmlHelper::article('Article Content', $this->testAttributes);
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('Article Content', $result);
        self::assertStringStartsWith('<article', $result);
        self::assertStringEndsWith('</article>', $result);
    }

    /**
     * Tests generating a section element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::section
     * @return void
     */
    public function testSection()
    {
        $result = HtmlHelper::section('Section Content', $this->testAttributes);
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('Section Content', $result);
        self::assertStringStartsWith('<section', $result);
        self::assertStringEndsWith('</section>', $result);
    }

    /**
     * Tests generating a nav element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::nav
     * @return void
     */
    public function testNav()
    {
        $result = HtmlHelper::nav('Navigation Content', $this->testAttributes);
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('Navigation Content', $result);
        self::assertStringStartsWith('<nav', $result);
        self::assertStringEndsWith('</nav>', $result);
    }

    /**
     * Tests generating an aside element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::aside
     * @return void
     */
    public function testAside()
    {
        $result = HtmlHelper::aside('Aside Content', $this->testAttributes);
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('Aside Content', $result);
        self::assertStringStartsWith('<aside', $result);
        self::assertStringEndsWith('</aside>', $result);
    }

    /**
     * Tests generating a header element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::header
     * @return void
     */
    public function testHeader()
    {
        $result = HtmlHelper::header('Header Content', $this->testAttributes);
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('Header Content', $result);
        self::assertStringStartsWith('<header', $result);
        self::assertStringEndsWith('</header>', $result);
    }

    /**
     * Tests generating a footer element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::footer
     * @return void
     */
    public function testFooter()
    {
        $result = HtmlHelper::footer('Footer Content', $this->testAttributes);
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('Footer Content', $result);
        self::assertStringStartsWith('<footer', $result);
        self::assertStringEndsWith('</footer>', $result);
    }

    /**
     * Tests generating a main element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::main
     * @return void
     */
    public function testMain()
    {
        $result = HtmlHelper::main('Main Content', $this->testAttributes);
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('Main Content', $result);
        self::assertStringStartsWith('<main', $result);
        self::assertStringEndsWith('</main>', $result);
    }

    /**
     * Tests generating a figure element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::figure
     * @return void
     */
    public function testFigure()
    {
        $result = HtmlHelper::figure('Figure Content', $this->testAttributes);
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('Figure Content', $result);
        self::assertStringStartsWith('<figure', $result);
        self::assertStringEndsWith('</figure>', $result);
    }

    /**
     * Tests generating a figcaption element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::figcaption
     * @return void
     */
    public function testFigcaption()
    {
        $result = HtmlHelper::figcaption('Caption Text', $this->testAttributes);
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('Caption Text', $result);
        self::assertStringStartsWith('<figcaption', $result);
        self::assertStringEndsWith('</figcaption>', $result);
    }

    /**
     * Tests generating a details element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::details
     * @return void
     */
    public function testDetails()
    {
        // Test closed details
        $result = HtmlHelper::details('Details Content', false, $this->testAttributes);
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('Details Content', $result);
        self::assertStringStartsWith('<details', $result);
        self::assertStringEndsWith('</details>', $result);
        self::assertStringNotContainsString('open="open"', $result);

        // Test open details
        $result = HtmlHelper::details('Details Content', true, $this->testAttributes);
        self::assertStringContainsString('open="open"', $result);
    }

    /**
     * Tests generating a summary element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::summary
     * @return void
     */
    public function testSummary()
    {
        $result = HtmlHelper::summary('Summary Text', $this->testAttributes);
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('Summary Text', $result);
        self::assertStringStartsWith('<summary', $result);
        self::assertStringEndsWith('</summary>', $result);
    }

    /**
     * Tests generating a dialog element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::dialog
     * @return void
     */
    public function testDialog()
    {
        // Test basic dialog
        $result = HtmlHelper::dialog('Dialog Content', false, false, $this->testAttributes);
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('Dialog Content', $result);
        self::assertStringStartsWith('<dialog', $result);
        self::assertStringEndsWith('</dialog>', $result);
        self::assertStringNotContainsString('open="open"', $result);
        self::assertStringNotContainsString('modal="modal"', $result);

        // Test open dialog
        $result = HtmlHelper::dialog('Dialog Content', true, false, $this->testAttributes);
        self::assertStringContainsString('open="open"', $result);

        // Test modal dialog
        $result = HtmlHelper::dialog('Dialog Content', false, true, $this->testAttributes);
        self::assertStringContainsString('modal="modal"', $result);
    }

    /**
     * Tests generating a meter element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::meter
     * @return void
     */
    public function testMeter()
    {
        // Test basic meter
        $result = HtmlHelper::meter('Progress', 75, 0, 100, null, null, null, $this->testAttributes);
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('Progress', $result);
        self::assertStringContainsString('value="75"', $result);
        self::assertStringContainsString('min="0"', $result);
        self::assertStringContainsString('max="100"', $result);
        self::assertStringStartsWith('<meter', $result);
        self::assertStringEndsWith('</meter>', $result);

        // Test meter with all attributes
        $result = HtmlHelper::meter('Progress', 75, 0, 100, 25, 85, 50, $this->testAttributes);
        self::assertStringContainsString('low="25"', $result);
        self::assertStringContainsString('high="85"', $result);
        self::assertStringContainsString('optimum="50"', $result);
    }

    /**
     * Tests generating a progress element with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\HtmlHelper::progress
     * @return void
     */
    public function testProgress()
    {
        // Test basic progress
        $result = HtmlHelper::progress('Loading...', null, null, $this->testAttributes);
        self::assertStringContainsString('id="CHESTNUT"', $result);
        self::assertStringContainsString('class="horseradish cheese peanuts"', $result);
        self::assertStringContainsString('data-beef-steak="XYZ "', $result);
        self::assertStringContainsString('Loading...', $result);
        self::assertStringStartsWith('<progress', $result);
        self::assertStringEndsWith('</progress>', $result);

        // Test progress with value and max
        $result = HtmlHelper::progress('75%', 75, 100, $this->testAttributes);
        self::assertStringContainsString('value="75"', $result);
        self::assertStringContainsString('max="100"', $result);
    }
}
