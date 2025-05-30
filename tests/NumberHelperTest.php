<?php

namespace AndreasGlaser\Helpers\Tests\Number;

use AndreasGlaser\Helpers\NumberHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * NumberHelperTest provides comprehensive unit tests for the NumberHelper class.
 *
 * This class tests number formatting, conversion, validation, and mathematical operations:
 * - Number formatting with thousands separators and decimal places
 * - Percentage calculations and formatting
 * - Roman numeral conversion (to and from)
 * - Number base conversion
 * - File size formatting
 * - Mathematical utilities (rounding, clamping, statistics)
 * - Number validation (even, odd, prime, range checking)
 * - Number parsing from formatted strings
 */
class NumberHelperTest extends BaseTest
{
    /**
     * Tests the ordinal() method for converting numbers to ordinal suffixes.
     * Verifies correct ordinal suffix generation for different numbers (1st, 2nd, 3rd, 4th, etc.).
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::ordinal
     * @return void
     */
    public function testOrdinal()
    {
        // Basic cases
        $this->assertEquals('st', NumberHelper::ordinal(1));
        $this->assertEquals('nd', NumberHelper::ordinal(2));
        $this->assertEquals('rd', NumberHelper::ordinal(3));
        $this->assertEquals('th', NumberHelper::ordinal(4));
        
        // Teen cases (special handling)
        $this->assertEquals('th', NumberHelper::ordinal(11));
        $this->assertEquals('th', NumberHelper::ordinal(12));
        $this->assertEquals('th', NumberHelper::ordinal(13));
        
        // Larger numbers
        $this->assertEquals('st', NumberHelper::ordinal(21));
        $this->assertEquals('nd', NumberHelper::ordinal(22));
        $this->assertEquals('rd', NumberHelper::ordinal(23));
        $this->assertEquals('th', NumberHelper::ordinal(24));
        
        // Hundreds
        $this->assertEquals('st', NumberHelper::ordinal(101));
        $this->assertEquals('th', NumberHelper::ordinal(111));
        $this->assertEquals('st', NumberHelper::ordinal(121));
    }

    /**
     * Tests the format() method for number formatting.
     * Verifies proper formatting with thousands separators and decimal places.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::format
     * @return void
     */
    public function testFormat()
    {
        // Default formatting
        $this->assertEquals('1,234.56', NumberHelper::format(1234.56));
        
        // Custom decimal places
        $this->assertEquals('1,234.6', NumberHelper::format(1234.56, 1));
        $this->assertEquals('1,235', NumberHelper::format(1234.56, 0));
        
        // Custom separators
        $this->assertEquals('1 234.56', NumberHelper::format(1234.56, 2, '.', ' '));
        $this->assertEquals('1.234,56', NumberHelper::format(1234.56, 2, ',', '.'));
        
        // Large numbers
        $this->assertEquals('1,000,000.00', NumberHelper::format(1000000));
        
        // Negative numbers
        $this->assertEquals('-1,234.56', NumberHelper::format(-1234.56));
        
        // Zero
        $this->assertEquals('0.00', NumberHelper::format(0));
    }

    /**
     * Tests the percentage() method for percentage formatting.
     * Verifies correct percentage string generation from decimals and numbers.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::percentage
     * @return void
     */
    public function testPercentage()
    {
        // From decimal
        $this->assertEquals('25.00%', NumberHelper::percentage(0.25, true));
        $this->assertEquals('50.00%', NumberHelper::percentage(0.5, true));
        $this->assertEquals('100.00%', NumberHelper::percentage(1.0, true));
        
        // From percentage value
        $this->assertEquals('25.00%', NumberHelper::percentage(25, false));
        $this->assertEquals('50.00%', NumberHelper::percentage(50, false));
        $this->assertEquals('100.00%', NumberHelper::percentage(100, false));
        
        // Custom decimal places
        $this->assertEquals('25.5%', NumberHelper::percentage(0.255, true, 1));
        $this->assertEquals('25%', NumberHelper::percentage(0.25, true, 0));
        
        // Edge cases
        $this->assertEquals('0.00%', NumberHelper::percentage(0, true));
        $this->assertEquals('150.00%', NumberHelper::percentage(1.5, true));
    }

    /**
     * Tests the percentageOf() method for calculating percentages from values.
     * Verifies correct percentage calculation and exception handling.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::percentageOf
     * @return void
     */
    public function testPercentageOf()
    {
        // Basic calculations
        $this->assertEquals(0.25, NumberHelper::percentageOf(25, 100));
        $this->assertEquals(0.5, NumberHelper::percentageOf(50, 100));
        $this->assertEquals(1.0, NumberHelper::percentageOf(100, 100));
        
        // Custom precision
        $this->assertEquals(0.333, NumberHelper::percentageOf(1, 3, 3));
        $this->assertEquals(0.33, NumberHelper::percentageOf(1, 3, 2));
        
        // Greater than 100%
        $this->assertEquals(1.5, NumberHelper::percentageOf(150, 100));
        
        // Zero value
        $this->assertEquals(0.0, NumberHelper::percentageOf(0, 100));
        
        // Exception for zero total
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Total cannot be zero for percentage calculation.');
        NumberHelper::percentageOf(25, 0);
    }

    /**
     * Tests the round() method for number rounding.
     * Verifies correct rounding with different precision and modes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::round
     * @return void
     */
    public function testRound()
    {
        // Default rounding (half up)
        $this->assertEquals(1.24, NumberHelper::round(1.235, 2));
        $this->assertEquals(1.0, NumberHelper::round(1.235, 0));
        
        // Different rounding modes
        $this->assertEquals(1.23, NumberHelper::round(1.234, 2, \PHP_ROUND_HALF_DOWN));
        $this->assertEquals(1.24, NumberHelper::round(1.236, 2, \PHP_ROUND_HALF_UP));
        $this->assertEquals(1.24, NumberHelper::round(1.235, 2, \PHP_ROUND_HALF_EVEN));
        
        // Negative numbers
        $this->assertEquals(-1.24, NumberHelper::round(-1.235, 2));
        
        // Zero precision
        $this->assertEquals(123.0, NumberHelper::round(123.456, 0));
    }

    /**
     * Tests the clamp() method for value clamping.
     * Verifies correct clamping between min and max values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::clamp
     * @return void
     */
    public function testClamp()
    {
        // Value within range
        $this->assertEquals(15, NumberHelper::clamp(15, 10, 20));
        
        // Value below minimum
        $this->assertEquals(10, NumberHelper::clamp(5, 10, 20));
        
        // Value above maximum
        $this->assertEquals(20, NumberHelper::clamp(25, 10, 20));
        
        // Float values
        $this->assertEquals(15.5, NumberHelper::clamp(15.5, 10.0, 20.0));
        $this->assertEquals(10.0, NumberHelper::clamp(5.5, 10.0, 20.0));
        
        // Edge case: min equals max
        $this->assertEquals(10, NumberHelper::clamp(15, 10, 10));
        
        // Exception for invalid range
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Minimum value cannot be greater than maximum value.');
        NumberHelper::clamp(15, 20, 10);
    }

    /**
     * Tests the fileSize() method for file size formatting.
     * Verifies correct file size formatting in binary and decimal units.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::fileSize
     * @return void
     */
    public function testFileSize()
    {
        // Zero bytes
        $this->assertEquals('0 B', NumberHelper::fileSize(0));
        
        // Binary units (default)
        $this->assertEquals('1.00 KB', NumberHelper::fileSize(1024));
        $this->assertEquals('1.00 MB', NumberHelper::fileSize(1024 * 1024));
        $this->assertEquals('1.00 GB', NumberHelper::fileSize(1024 * 1024 * 1024));
        
        // Decimal units
        $this->assertEquals('1.00 kB', NumberHelper::fileSize(1000, 2, false));
        $this->assertEquals('1.00 MB', NumberHelper::fileSize(1000000, 2, false));
        
        // Custom decimal places
        $this->assertEquals('1.5 KB', NumberHelper::fileSize(1536, 1));
        $this->assertEquals('2 KB', NumberHelper::fileSize(1536, 0));
        
        // Large values
        $this->assertEquals('1.00 TB', NumberHelper::fileSize(1024 ** 4));
        
        // Small values
        $this->assertEquals('512.00 B', NumberHelper::fileSize(512));
    }

    /**
     * Tests the toRoman() method for Roman numeral conversion.
     * Verifies correct conversion of numbers to Roman numerals.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::toRoman
     * @return void
     */
    public function testToRoman()
    {
        // Basic numbers
        $this->assertEquals('I', NumberHelper::toRoman(1));
        $this->assertEquals('V', NumberHelper::toRoman(5));
        $this->assertEquals('X', NumberHelper::toRoman(10));
        $this->assertEquals('L', NumberHelper::toRoman(50));
        $this->assertEquals('C', NumberHelper::toRoman(100));
        $this->assertEquals('D', NumberHelper::toRoman(500));
        $this->assertEquals('M', NumberHelper::toRoman(1000));
        
        // Compound numbers
        $this->assertEquals('IV', NumberHelper::toRoman(4));
        $this->assertEquals('IX', NumberHelper::toRoman(9));
        $this->assertEquals('XL', NumberHelper::toRoman(40));
        $this->assertEquals('XC', NumberHelper::toRoman(90));
        $this->assertEquals('CD', NumberHelper::toRoman(400));
        $this->assertEquals('CM', NumberHelper::toRoman(900));
        
        // Complex numbers
        $this->assertEquals('MCMLXXXIV', NumberHelper::toRoman(1984));
        $this->assertEquals('MMXXI', NumberHelper::toRoman(2021));
        $this->assertEquals('MMMCMXCIX', NumberHelper::toRoman(3999));
        
        // Edge cases - invalid range
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Number must be between 1 and 3999 for Roman numeral conversion.');
        NumberHelper::toRoman(0);
    }

    /**
     * Tests exception handling for toRoman() with invalid range.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::toRoman
     * @return void
     */
    public function testToRomanInvalidRange()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Number must be between 1 and 3999 for Roman numeral conversion.');
        NumberHelper::toRoman(4000);
    }

    /**
     * Tests the fromRoman() method for Roman numeral parsing.
     * Verifies correct conversion of Roman numerals back to numbers.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::fromRoman
     * @return void
     */
    public function testFromRoman()
    {
        // Basic numbers
        $this->assertEquals(1, NumberHelper::fromRoman('I'));
        $this->assertEquals(5, NumberHelper::fromRoman('V'));
        $this->assertEquals(10, NumberHelper::fromRoman('X'));
        $this->assertEquals(50, NumberHelper::fromRoman('L'));
        $this->assertEquals(100, NumberHelper::fromRoman('C'));
        $this->assertEquals(500, NumberHelper::fromRoman('D'));
        $this->assertEquals(1000, NumberHelper::fromRoman('M'));
        
        // Compound numbers
        $this->assertEquals(4, NumberHelper::fromRoman('IV'));
        $this->assertEquals(9, NumberHelper::fromRoman('IX'));
        $this->assertEquals(40, NumberHelper::fromRoman('XL'));
        $this->assertEquals(90, NumberHelper::fromRoman('XC'));
        $this->assertEquals(400, NumberHelper::fromRoman('CD'));
        $this->assertEquals(900, NumberHelper::fromRoman('CM'));
        
        // Complex numbers
        $this->assertEquals(1984, NumberHelper::fromRoman('MCMLXXXIV'));
        $this->assertEquals(2021, NumberHelper::fromRoman('MMXXI'));
        $this->assertEquals(3999, NumberHelper::fromRoman('MMMCMXCIX'));
        
        // Case insensitive
        $this->assertEquals(1984, NumberHelper::fromRoman('mcmlxxxiv'));
        $this->assertEquals(1984, NumberHelper::fromRoman('McMLXXXiv'));
        
        // With whitespace
        $this->assertEquals(1984, NumberHelper::fromRoman(' MCMLXXXIV '));
    }

    /**
     * Tests exception handling for fromRoman() with invalid characters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::fromRoman
     * @return void
     */
    public function testFromRomanInvalidCharacter()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Roman numeral character: Z');
        NumberHelper::fromRoman('MCMLXXXIZ');
    }

    /**
     * Tests the changeBase() method for number base conversion.
     * Verifies correct conversion between different number bases.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::changeBase
     * @return void
     */
    public function testChangeBase()
    {
        // Binary to decimal
        $this->assertEquals('10', NumberHelper::changeBase('1010', 2, 10));
        
        // Decimal to hexadecimal
        $this->assertEquals('ff', NumberHelper::changeBase(255, 10, 16));
        $this->assertEquals('100', NumberHelper::changeBase(256, 10, 16));
        
        // Hexadecimal to decimal
        $this->assertEquals('255', NumberHelper::changeBase('ff', 16, 10));
        $this->assertEquals('256', NumberHelper::changeBase('100', 16, 10));
        
        // Octal to decimal
        $this->assertEquals('64', NumberHelper::changeBase('100', 8, 10));
        
        // Base 36
        $this->assertEquals('zz', NumberHelper::changeBase(1295, 10, 36));
        $this->assertEquals('1295', NumberHelper::changeBase('zz', 36, 10));
    }

    /**
     * Tests exception handling for changeBase() with invalid base.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::changeBase
     * @return void
     */
    public function testChangeBaseInvalidFromBase()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Base must be between 2 and 36.');
        NumberHelper::changeBase(100, 1, 10);
    }

    /**
     * Tests exception handling for changeBase() with invalid target base.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::changeBase
     * @return void
     */
    public function testChangeBaseInvalidToBase()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Base must be between 2 and 36.');
        NumberHelper::changeBase(100, 10, 37);
    }

    /**
     * Tests the inRange() method for range checking.
     * Verifies correct range validation for numbers.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::inRange
     * @return void
     */
    public function testInRange()
    {
        // Within range
        $this->assertTrue(NumberHelper::inRange(15, 10, 20));
        $this->assertTrue(NumberHelper::inRange(10, 10, 20)); // Min boundary
        $this->assertTrue(NumberHelper::inRange(20, 10, 20)); // Max boundary
        
        // Outside range
        $this->assertFalse(NumberHelper::inRange(5, 10, 20));
        $this->assertFalse(NumberHelper::inRange(25, 10, 20));
        
        // Float values
        $this->assertTrue(NumberHelper::inRange(15.5, 10.0, 20.0));
        $this->assertFalse(NumberHelper::inRange(9.9, 10.0, 20.0));
        
        // Negative ranges
        $this->assertTrue(NumberHelper::inRange(-15, -20, -10));
        $this->assertFalse(NumberHelper::inRange(-25, -20, -10));
    }

    /**
     * Tests the isEven() method for even number detection.
     * Verifies correct identification of even numbers.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::isEven
     * @return void
     */
    public function testIsEven()
    {
        // Even numbers
        $this->assertTrue(NumberHelper::isEven(0));
        $this->assertTrue(NumberHelper::isEven(2));
        $this->assertTrue(NumberHelper::isEven(4));
        $this->assertTrue(NumberHelper::isEven(100));
        $this->assertTrue(NumberHelper::isEven(-4));
        
        // Odd numbers
        $this->assertFalse(NumberHelper::isEven(1));
        $this->assertFalse(NumberHelper::isEven(3));
        $this->assertFalse(NumberHelper::isEven(99));
        $this->assertFalse(NumberHelper::isEven(-3));
    }

    /**
     * Tests the isOdd() method for odd number detection.
     * Verifies correct identification of odd numbers.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::isOdd
     * @return void
     */
    public function testIsOdd()
    {
        // Odd numbers
        $this->assertTrue(NumberHelper::isOdd(1));
        $this->assertTrue(NumberHelper::isOdd(3));
        $this->assertTrue(NumberHelper::isOdd(99));
        $this->assertTrue(NumberHelper::isOdd(-3));
        
        // Even numbers
        $this->assertFalse(NumberHelper::isOdd(0));
        $this->assertFalse(NumberHelper::isOdd(2));
        $this->assertFalse(NumberHelper::isOdd(4));
        $this->assertFalse(NumberHelper::isOdd(100));
        $this->assertFalse(NumberHelper::isOdd(-4));
    }

    /**
     * Tests the isPrime() method for prime number detection.
     * Verifies correct identification of prime numbers.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::isPrime
     * @return void
     */
    public function testIsPrime()
    {
        // Prime numbers
        $this->assertTrue(NumberHelper::isPrime(2));
        $this->assertTrue(NumberHelper::isPrime(3));
        $this->assertTrue(NumberHelper::isPrime(5));
        $this->assertTrue(NumberHelper::isPrime(7));
        $this->assertTrue(NumberHelper::isPrime(11));
        $this->assertTrue(NumberHelper::isPrime(13));
        $this->assertTrue(NumberHelper::isPrime(17));
        $this->assertTrue(NumberHelper::isPrime(19));
        $this->assertTrue(NumberHelper::isPrime(97));
        
        // Non-prime numbers
        $this->assertFalse(NumberHelper::isPrime(0));
        $this->assertFalse(NumberHelper::isPrime(1));
        $this->assertFalse(NumberHelper::isPrime(4));
        $this->assertFalse(NumberHelper::isPrime(6));
        $this->assertFalse(NumberHelper::isPrime(8));
        $this->assertFalse(NumberHelper::isPrime(9));
        $this->assertFalse(NumberHelper::isPrime(10));
        $this->assertFalse(NumberHelper::isPrime(15));
        $this->assertFalse(NumberHelper::isPrime(100));
        
        // Negative numbers
        $this->assertFalse(NumberHelper::isPrime(-7));
    }

    /**
     * Tests the difference() method for absolute difference calculation.
     * Verifies correct calculation of absolute differences.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::difference
     * @return void
     */
    public function testDifference()
    {
        // Positive differences
        $this->assertEquals(7, NumberHelper::difference(10, 3));
        $this->assertEquals(7, NumberHelper::difference(3, 10));
        
        // Zero difference
        $this->assertEquals(0, NumberHelper::difference(5, 5));
        
        // Negative numbers
        $this->assertEquals(7, NumberHelper::difference(-3, -10));
        $this->assertEquals(13, NumberHelper::difference(-3, 10));
        
        // Float numbers
        $this->assertEquals(2.5, NumberHelper::difference(7.5, 5.0));
    }

    /**
     * Tests the average() method for calculating averages.
     * Verifies correct average calculation and exception handling.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::average
     * @return void
     */
    public function testAverage()
    {
        // Integer array
        $this->assertEquals(3.0, NumberHelper::average([1, 2, 3, 4, 5]));
        
        // Float array
        $this->assertEquals(2.5, NumberHelper::average([1.0, 2.0, 3.0, 4.0]));
        
        // Mixed array
        $this->assertEquals(2.75, NumberHelper::average([1, 2.5, 3, 4.5]));
        
        // Single element
        $this->assertEquals(42.0, NumberHelper::average([42]));
        
        // Negative numbers
        $this->assertEquals(-2.0, NumberHelper::average([-1, -2, -3]));
    }

    /**
     * Tests exception handling for average() with empty array.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::average
     * @return void
     */
    public function testAverageEmptyArray()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot calculate average of empty array.');
        NumberHelper::average([]);
    }

    /**
     * Tests exception handling for average() with non-numeric values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::average
     * @return void
     */
    public function testAverageNonNumericValues()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('All array elements must be numeric.');
        NumberHelper::average([1, 2, 'three', 4]);
    }

    /**
     * Tests the median() method for finding median values.
     * Verifies correct median calculation for odd and even length arrays.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::median
     * @return void
     */
    public function testMedian()
    {
        // Odd length array
        $this->assertEquals(3.0, NumberHelper::median([1, 2, 3, 4, 5]));
        $this->assertEquals(3.0, NumberHelper::median([5, 1, 3, 2, 4])); // Unsorted
        
        // Even length array
        $this->assertEquals(2.5, NumberHelper::median([1, 2, 3, 4]));
        $this->assertEquals(2.5, NumberHelper::median([4, 1, 3, 2])); // Unsorted
        
        // Single element
        $this->assertEquals(42.0, NumberHelper::median([42]));
        
        // Two elements
        $this->assertEquals(3.0, NumberHelper::median([2, 4]));
        
        // Negative numbers
        $this->assertEquals(-2.0, NumberHelper::median([-5, -2, -1]));
        
        // Float numbers
        $this->assertEquals(2.5, NumberHelper::median([1.5, 2.5, 3.5]));
    }

    /**
     * Tests exception handling for median() with empty array.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::median
     * @return void
     */
    public function testMedianEmptyArray()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot calculate median of empty array.');
        NumberHelper::median([]);
    }

    /**
     * Tests exception handling for median() with non-numeric values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::median
     * @return void
     */
    public function testMedianNonNumericValues()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('All array elements must be numeric.');
        NumberHelper::median([1, 2, 'three', 4]);
    }

    /**
     * Tests the parse() method for parsing formatted numbers.
     * Verifies correct parsing of numbers with different separators.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::parse
     * @return void
     */
    public function testParse()
    {
        // Default format (US/UK)
        $this->assertEquals(1234.56, NumberHelper::parse('1,234.56'));
        $this->assertEquals(1000000.0, NumberHelper::parse('1,000,000'));
        $this->assertEquals(123.45, NumberHelper::parse('123.45'));
        
        // European format
        $this->assertEquals(1234.56, NumberHelper::parse('1 234,56', ',', ' '));
        $this->assertEquals(1234.56, NumberHelper::parse('1.234,56', ',', '.'));
        
        // No thousands separator
        $this->assertEquals(1234.56, NumberHelper::parse('1234.56'));
        
        // Negative numbers
        $this->assertEquals(-1234.56, NumberHelper::parse('-1,234.56'));
        
        // Zero
        $this->assertEquals(0.0, NumberHelper::parse('0.00'));
    }
}
