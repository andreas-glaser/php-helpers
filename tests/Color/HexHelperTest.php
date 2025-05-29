<?php

namespace Tests\Color;

use PHPUnit\Framework\TestCase;
use AndreasGlaser\Helpers\Color\HexHelper;

/**
 * HexHelperTest provides unit tests for the HexHelper class.
 *
 * This class tests hexadecimal color manipulation methods:
 * - Brightness adjustment with positive and negative values
 * - Support for 3-character and 6-character hex codes
 * - Edge cases and boundary conditions
 * - Color format normalization
 */
class HexHelperTest extends TestCase
{
    // ========================================
    // Tests for adjustBrightness() method
    // ========================================

    /**
     * Tests adjustBrightness() with 6-character hex codes and positive steps.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessWithSixCharHexPositive()
    {
        // Test making colors lighter
        $result = HexHelper::adjustBrightness('#000000', 50);
        $this->assertEquals('#323232', $result);

        $result = HexHelper::adjustBrightness('#FF0000', 50);
        $this->assertEquals('#ff3232', $result);

        $result = HexHelper::adjustBrightness('#00FF00', 100);
        $this->assertEquals('#64ff64', $result);

        $result = HexHelper::adjustBrightness('#0000FF', 25);
        $this->assertEquals('#1919ff', $result);
    }

    /**
     * Tests adjustBrightness() with 6-character hex codes and negative steps.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessWithSixCharHexNegative()
    {
        // Test making colors darker
        $result = HexHelper::adjustBrightness('#FFFFFF', -50);
        $this->assertEquals('#cdcdcd', $result);

        $result = HexHelper::adjustBrightness('#FF0000', -50);
        $this->assertEquals('#cd0000', $result);

        $result = HexHelper::adjustBrightness('#00FF00', -100);
        $this->assertEquals('#009b00', $result);

        $result = HexHelper::adjustBrightness('#0000FF', -25);
        $this->assertEquals('#0000e6', $result);
    }

    /**
     * Tests adjustBrightness() with 3-character hex codes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessWithThreeCharHex()
    {
        // Test 3-character hex codes (should be expanded to 6-character)
        $result = HexHelper::adjustBrightness('#000', 50);
        $this->assertEquals('#323232', $result);

        $result = HexHelper::adjustBrightness('#F00', 50);
        $this->assertEquals('#ff3232', $result);

        $result = HexHelper::adjustBrightness('#0F0', 100);
        $this->assertEquals('#64ff64', $result);

        $result = HexHelper::adjustBrightness('#00F', 25);
        $this->assertEquals('#1919ff', $result);

        $result = HexHelper::adjustBrightness('#FFF', -50);
        $this->assertEquals('#cdcdcd', $result);
    }

    /**
     * Tests adjustBrightness() without hash prefix.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessWithoutHashPrefix()
    {
        // Test hex codes without '#' prefix
        $result = HexHelper::adjustBrightness('000000', 50);
        $this->assertEquals('#323232', $result);

        $result = HexHelper::adjustBrightness('FF0000', -50);
        $this->assertEquals('#cd0000', $result);

        $result = HexHelper::adjustBrightness('F00', 50);
        $this->assertEquals('#ff3232', $result);
    }

    /**
     * Tests adjustBrightness() with zero steps (no change).
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessWithZeroSteps()
    {
        // Test no brightness change
        $result = HexHelper::adjustBrightness('#FF0000', 0);
        $this->assertEquals('#ff0000', $result);

        $result = HexHelper::adjustBrightness('#00FF00', 0);
        $this->assertEquals('#00ff00', $result);

        $result = HexHelper::adjustBrightness('#0000FF', 0);
        $this->assertEquals('#0000ff', $result);

        $result = HexHelper::adjustBrightness('#FFFFFF', 0);
        $this->assertEquals('#ffffff', $result);
    }

    /**
     * Tests adjustBrightness() with maximum positive steps.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessMaxPositive()
    {
        // Test maximum brightness increase (255)
        $result = HexHelper::adjustBrightness('#000000', 255);
        $this->assertEquals('#ffffff', $result);

        $result = HexHelper::adjustBrightness('#808080', 255);
        $this->assertEquals('#ffffff', $result); // Should cap at white

        $result = HexHelper::adjustBrightness('#FF0000', 255);
        $this->assertEquals('#ffffff', $result); // Should cap at white
    }

    /**
     * Tests adjustBrightness() with maximum negative steps.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessMaxNegative()
    {
        // Test maximum brightness decrease (-255)
        $result = HexHelper::adjustBrightness('#FFFFFF', -255);
        $this->assertEquals('#000000', $result);

        $result = HexHelper::adjustBrightness('#808080', -255);
        $this->assertEquals('#000000', $result); // Should cap at black

        $result = HexHelper::adjustBrightness('#FF0000', -255);
        $this->assertEquals('#000000', $result); // Should cap at black
    }

    /**
     * Tests adjustBrightness() with steps beyond valid range.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessBeyondValidRange()
    {
        // Test steps beyond -255 to 255 range (should be clamped)
        $result = HexHelper::adjustBrightness('#808080', 500);
        $this->assertEquals('#ffffff', $result); // Should be treated as 255

        $result = HexHelper::adjustBrightness('#808080', -500);
        $this->assertEquals('#000000', $result); // Should be treated as -255

        $result = HexHelper::adjustBrightness('#000000', 1000);
        $this->assertEquals('#ffffff', $result); // Should be treated as 255

        $result = HexHelper::adjustBrightness('#FFFFFF', -1000);
        $this->assertEquals('#000000', $result); // Should be treated as -255
    }

    /**
     * Tests adjustBrightness() with mixed case hex codes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessWithMixedCase()
    {
        // Test mixed case input (should normalize to lowercase)
        $result = HexHelper::adjustBrightness('#FfFfFf', -50);
        $this->assertEquals('#cdcdcd', $result);

        $result = HexHelper::adjustBrightness('#Ff0000', 50);
        $this->assertEquals('#ff3232', $result);

        $result = HexHelper::adjustBrightness('#aAbBcC', 0);
        $this->assertEquals('#aabbcc', $result);

        $result = HexHelper::adjustBrightness('AbCdEf', 10);
        $this->assertEquals('#b5d7f9', $result);
    }

    /**
     * Tests adjustBrightness() with specific color values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessSpecificColors()
    {
        // Test specific common colors
        $red = '#FF0000';
        $green = '#00FF00';
        $blue = '#0000FF';
        $white = '#FFFFFF';
        $black = '#000000';
        $gray = '#808080';

        // Make red darker
        $result = HexHelper::adjustBrightness($red, -100);
        $this->assertEquals('#9b0000', $result);

        // Make green lighter
        $result = HexHelper::adjustBrightness($green, 50);
        $this->assertEquals('#32ff32', $result);

        // Make blue darker
        $result = HexHelper::adjustBrightness($blue, -50);
        $this->assertEquals('#0000cd', $result);

        // Make gray lighter
        $result = HexHelper::adjustBrightness($gray, 64);
        $this->assertEquals('#c0c0c0', $result);

        // Make gray darker
        $result = HexHelper::adjustBrightness($gray, -64);
        $this->assertEquals('#404040', $result);
    }

    /**
     * Tests adjustBrightness() output format consistency.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessOutputFormat()
    {
        // Test that output is always 6-character hex with # prefix
        $result = HexHelper::adjustBrightness('#F00', 0);
        $this->assertStringStartsWith('#', $result);
        $this->assertEquals(7, strlen($result)); // # + 6 characters

        $result = HexHelper::adjustBrightness('000000', 0);
        $this->assertStringStartsWith('#', $result);
        $this->assertEquals(7, strlen($result));

        $result = HexHelper::adjustBrightness('#123456', 50);
        $this->assertStringStartsWith('#', $result);
        $this->assertEquals(7, strlen($result));

        // Check that output is valid hex characters
        $result = HexHelper::adjustBrightness('#ABCDEF', 10);
        $this->assertMatchesRegularExpression('/^#[0-9a-f]{6}$/', $result);
    }

    /**
     * Tests adjustBrightness() with edge color values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessEdgeValues()
    {
        // Test edge values that might cause overflow/underflow
        $result = HexHelper::adjustBrightness('#010101', -1);
        $this->assertEquals('#000000', $result); // Should clamp to 0

        $result = HexHelper::adjustBrightness('#FEFEFE', 1);
        $this->assertEquals('#ffffff', $result); // Should clamp to 255

        $result = HexHelper::adjustBrightness('#010203', -2);
        $this->assertEquals('#000001', $result);

        $result = HexHelper::adjustBrightness('#FDFEFD', 2);
        $this->assertEquals('#ffffff', $result);
    }

    /**
     * Tests adjustBrightness() mathematical correctness.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessMathematicalCorrectness()
    {
        // Test that the mathematical operations are correct
        // #808080 = rgb(128, 128, 128)
        // Adding 50 should give rgb(178, 178, 178) = #B2B2B2
        $result = HexHelper::adjustBrightness('#808080', 50);
        $this->assertEquals('#b2b2b2', $result);

        // #404040 = rgb(64, 64, 64)
        // Subtracting 32 should give rgb(32, 32, 32) = #202020
        $result = HexHelper::adjustBrightness('#404040', -32);
        $this->assertEquals('#202020', $result);

        // #C0C0C0 = rgb(192, 192, 192)
        // Adding 63 should give rgb(255, 255, 255) = #FFFFFF (clamped)
        $result = HexHelper::adjustBrightness('#C0C0C0', 63);
        $this->assertEquals('#ffffff', $result);
    }

    /**
     * Tests adjustBrightness() performance with multiple calls.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessPerformance()
    {
        // Test performance and consistency with multiple calls
        $colors = ['#FF0000', '#00FF00', '#0000FF', '#FFFFFF', '#000000', '#808080'];
        $steps = [-100, -50, 0, 50, 100];

        foreach ($colors as $color) {
            foreach ($steps as $step) {
                $result1 = HexHelper::adjustBrightness($color, $step);
                $result2 = HexHelper::adjustBrightness($color, $step);
                
                // Results should be consistent
                $this->assertEquals($result1, $result2, "Inconsistent results for color {$color} with step {$step}");
                
                // Result should be valid hex format
                $this->assertMatchesRegularExpression('/^#[0-9a-f]{6}$/', $result1);
            }
        }
    }

    /**
     * Tests adjustBrightness() return type.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Color\HexHelper::adjustBrightness
     * @return void
     */
    public function testAdjustBrightnessReturnType()
    {
        // Test that method always returns a string
        $result = HexHelper::adjustBrightness('#FF0000', 50);
        $this->assertIsString($result);

        $result = HexHelper::adjustBrightness('#000', 0);
        $this->assertIsString($result);

        $result = HexHelper::adjustBrightness('FFFFFF', -100);
        $this->assertIsString($result);
    }
} 