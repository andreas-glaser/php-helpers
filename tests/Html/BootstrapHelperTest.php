<?php

namespace Tests\Html;

use PHPUnit\Framework\TestCase;
use AndreasGlaser\Helpers\Html\BootstrapHelper;
use AndreasGlaser\Helpers\Html\AttributesHelper;

/**
 * BootstrapHelperTest provides unit tests for the BootstrapHelper class.
 *
 * This class tests Bootstrap component generation methods:
 * - Glyphicon creation with various names and attributes
 * - HTML output validation and structure
 * - Attribute handling and CSS class management
 * - Edge cases and special characters
 * 
 * Each method is tested with valid inputs, invalid inputs, edge cases,
 * and proper HTML structure generation.
 */
class BootstrapHelperTest extends TestCase
{
    // ========================================
    // Tests for glyphIcon() method
    // ========================================

    /**
     * Tests the glyphIcon() method with simple icon name.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithSimpleName()
    {
        $result = BootstrapHelper::glyphIcon('home');

        $this->assertStringContainsString('<span', $result);
        $this->assertStringContainsString('class="glyphicon glyphicon-home"', $result);
        $this->assertStringContainsString('></span>', $result);
        $this->assertEquals('<span class="glyphicon glyphicon-home"></span>', $result);
    }

    /**
     * Tests the glyphIcon() method with hyphenated icon name.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithHyphenatedName()
    {
        $result = BootstrapHelper::glyphIcon('chevron-right');

        $this->assertStringContainsString('glyphicon-chevron-right', $result);
        $this->assertEquals('<span class="glyphicon glyphicon-chevron-right"></span>', $result);
    }

    /**
     * Tests the glyphIcon() method with underscore icon name.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithUnderscoreName()
    {
        $result = BootstrapHelper::glyphIcon('log_in');

        $this->assertStringContainsString('glyphicon-log_in', $result);
        $this->assertEquals('<span class="glyphicon glyphicon-log_in"></span>', $result);
    }

    /**
     * Tests the glyphIcon() method with numeric icon name.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithNumericName()
    {
        $result = BootstrapHelper::glyphIcon('1-circle');

        $this->assertStringContainsString('glyphicon-1-circle', $result);
        $this->assertEquals('<span class="glyphicon glyphicon-1-circle"></span>', $result);
    }

    /**
     * Tests the glyphIcon() method with empty icon name.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithEmptyName()
    {
        $result = BootstrapHelper::glyphIcon('');

        $this->assertEquals('<span class="glyphicon glyphicon-"></span>', $result);
    }

    /**
     * Tests the glyphIcon() method with null attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithNullAttributes()
    {
        $result = BootstrapHelper::glyphIcon('star', null);

        $this->assertEquals('<span class="glyphicon glyphicon-star"></span>', $result);
    }

    /**
     * Tests the glyphIcon() method with empty array attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithEmptyArrayAttributes()
    {
        $result = BootstrapHelper::glyphIcon('star', []);

        $this->assertEquals('<span class="glyphicon glyphicon-star"></span>', $result);
    }

    /**
     * Tests the glyphIcon() method with AttributesHelper instance.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithAttributesHelperInstance()
    {
        $attributes = new AttributesHelper();
        $attributes->setId('my-icon');

        $result = BootstrapHelper::glyphIcon('heart', $attributes);

        $this->assertStringContainsString('id="my-icon"', $result);
        $this->assertStringContainsString('class="glyphicon glyphicon-heart"', $result);
    }

    /**
     * Tests the glyphIcon() method with array attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithArrayAttributes()
    {
        $attributes = [
            'id' => 'icon-id',
            'title' => 'My Icon'
        ];

        $result = BootstrapHelper::glyphIcon('ok', $attributes);

        $this->assertStringContainsString('id="icon-id"', $result);
        $this->assertStringContainsString('title="My Icon"', $result);
        $this->assertStringContainsString('class="glyphicon glyphicon-ok"', $result);
    }

    /**
     * Tests the glyphIcon() method with additional CSS classes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithAdditionalClasses()
    {
        $attributes = [
            'class' => 'icon-large text-primary'
        ];

        $result = BootstrapHelper::glyphIcon('search', $attributes);

        // Classes are added first, then glyphicon classes are appended
        $this->assertStringContainsString('class="icon-large text-primary glyphicon glyphicon-search"', $result);
    }

    /**
     * Tests the glyphIcon() method with style attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithStyleAttributes()
    {
        $attributes = [
            'style' => 'color: red; font-size: 16px;'
        ];

        $result = BootstrapHelper::glyphIcon('warning-sign', $attributes);

        // Style formatting removes spaces around colons and semicolons
        $this->assertStringContainsString('style="color:red;font-size:16px"', $result);
        $this->assertStringContainsString('class="glyphicon glyphicon-warning-sign"', $result);
    }

    /**
     * Tests the glyphIcon() method with data attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithDataAttributes()
    {
        $attributes = [
            'data-toggle' => 'tooltip',
            'data-placement' => 'top'
        ];

        $result = BootstrapHelper::glyphIcon('info-sign', $attributes);

        $this->assertStringContainsString('data-toggle="tooltip"', $result);
        $this->assertStringContainsString('data-placement="top"', $result);
        $this->assertStringContainsString('class="glyphicon glyphicon-info-sign"', $result);
    }

    /**
     * Tests the glyphIcon() method with ARIA attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithAriaAttributes()
    {
        $attributes = [
            'aria-hidden' => 'true',
            'aria-label' => 'Close'
        ];

        $result = BootstrapHelper::glyphIcon('remove', $attributes);

        $this->assertStringContainsString('aria-hidden="true"', $result);
        $this->assertStringContainsString('aria-label="Close"', $result);
        $this->assertStringContainsString('class="glyphicon glyphicon-remove"', $result);
    }

    /**
     * Tests the glyphIcon() method with multiple attributes combined.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithMultipleAttributes()
    {
        $attributes = [
            'id' => 'save-icon',
            'class' => 'icon-2x text-success',
            'title' => 'Save Document',
            'data-action' => 'save',
            'aria-hidden' => 'false'
        ];

        $result = BootstrapHelper::glyphIcon('floppy-disk', $attributes);

        $this->assertStringContainsString('id="save-icon"', $result);
        // Classes are added first, then glyphicon classes are appended
        $this->assertStringContainsString('class="icon-2x text-success glyphicon glyphicon-floppy-disk"', $result);
        $this->assertStringContainsString('title="Save Document"', $result);
        $this->assertStringContainsString('data-action="save"', $result);
        $this->assertStringContainsString('aria-hidden="false"', $result);
    }

    /**
     * Tests the glyphIcon() method with common Bootstrap icon names.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithCommonBootstrapIcons()
    {
        $commonIcons = [
            'asterisk', 'plus', 'euro', 'minus', 'cloud', 'envelope', 'pencil', 'glass',
            'music', 'search', 'heart', 'star', 'star-empty', 'user', 'film', 'th-large',
            'th', 'th-list', 'ok', 'remove', 'zoom-in', 'zoom-out', 'off', 'signal',
            'cog', 'trash', 'home', 'file', 'time', 'road', 'download-alt', 'download'
        ];

        foreach ($commonIcons as $iconName) {
            $result = BootstrapHelper::glyphIcon($iconName);
            
            $this->assertStringContainsString("glyphicon glyphicon-{$iconName}", $result);
            $this->assertStringStartsWith('<span', $result);
            $this->assertStringEndsWith('</span>', $result);
        }
    }

    /**
     * Tests the glyphIcon() method with special characters in icon name.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithSpecialCharacters()
    {
        $result = BootstrapHelper::glyphIcon('arrow-left');

        $this->assertStringContainsString('glyphicon-arrow-left', $result);
        $this->assertEquals('<span class="glyphicon glyphicon-arrow-left"></span>', $result);
    }

    /**
     * Tests the glyphIcon() method with long icon name.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithLongName()
    {
        $longIconName = 'very-long-icon-name-with-multiple-hyphens';
        $result = BootstrapHelper::glyphIcon($longIconName);

        $this->assertStringContainsString("glyphicon-{$longIconName}", $result);
        $this->assertEquals("<span class=\"glyphicon glyphicon-{$longIconName}\"></span>", $result);
    }

    /**
     * Tests the glyphIcon() method ensures empty span content.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconHasEmptyContent()
    {
        $result = BootstrapHelper::glyphIcon('home');

        // The span has empty content between opening and closing tags
        $this->assertStringContainsString('></span>', $result);
        $this->assertStringStartsWith('<span', $result);
        $this->assertStringEndsWith('></span>', $result);
        // Verify the content between tags is empty
        $this->assertMatchesRegularExpression('/<span[^>]*><\/span>/', $result);
    }

    /**
     * Tests the glyphIcon() method return type.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconReturnsString()
    {
        $result = BootstrapHelper::glyphIcon('test');

        $this->assertIsString($result);
    }

    /**
     * Tests the glyphIcon() method with boolean-like icon names.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithBooleanLikeNames()
    {
        $booleanLikeIcons = ['ok', 'remove', 'on', 'off', 'yes', 'no'];

        foreach ($booleanLikeIcons as $iconName) {
            $result = BootstrapHelper::glyphIcon($iconName);
            
            $this->assertStringContainsString("glyphicon-{$iconName}", $result);
            $this->assertEquals("<span class=\"glyphicon glyphicon-{$iconName}\"></span>", $result);
        }
    }

    /**
     * Tests the glyphIcon() method with numeric string icon names.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconWithNumericStringNames()
    {
        $numericIcons = ['1', '2', '3', '10', '100'];

        foreach ($numericIcons as $iconName) {
            $result = BootstrapHelper::glyphIcon($iconName);
            
            $this->assertStringContainsString("glyphicon-{$iconName}", $result);
            $this->assertEquals("<span class=\"glyphicon glyphicon-{$iconName}\"></span>", $result);
        }
    }

    /**
     * Tests the glyphIcon() method maintains class order.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconMaintainsClassOrder()
    {
        $result = BootstrapHelper::glyphIcon('home');

        // Should always have 'glyphicon' class first, then 'glyphicon-{name}'
        $this->assertStringContainsString('class="glyphicon glyphicon-home"', $result);
        
        // Verify order by checking position
        $position1 = strpos($result, 'glyphicon ');
        $position2 = strpos($result, 'glyphicon-home');
        $this->assertLessThan($position2, $position1);
    }

    /**
     * Tests the glyphIcon() method performance with multiple calls.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\BootstrapHelper::glyphIcon
     * @return void
     */
    public function testGlyphIconPerformanceWithMultipleCalls()
    {
        $iconNames = ['home', 'user', 'search', 'star', 'heart'];
        $results = [];

        foreach ($iconNames as $iconName) {
            $results[] = BootstrapHelper::glyphIcon($iconName);
        }

        $this->assertCount(5, $results);
        
        foreach ($results as $index => $result) {
            $expectedIconName = $iconNames[$index];
            $this->assertStringContainsString("glyphicon-{$expectedIconName}", $result);
        }
    }
} 