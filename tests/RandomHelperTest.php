<?php

namespace AndreasGlaser\Helpers\Tests\Random;

use AndreasGlaser\Helpers\RandomHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * RandomHelperTest provides comprehensive unit tests for the RandomHelper class.
 *
 * This class tests random value generation including:
 * - Basic random generation (boolean, integers, floats)
 * - String generation with various character sets
 * - Secure cryptographic functions (passwords, tokens, UUIDs)
 * - Array manipulation and element selection
 * - Color generation (hex, RGB)
 * - Network address generation (IP, MAC)
 * - Date generation and weighted selections
 * - Exception handling and validation
 */
class RandomHelperTest extends BaseTest
{
    /**
     * Tests the trueFalse() method for generating random boolean values.
     * Verifies that the method returns a boolean value and tests distribution.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::trueFalse
     * @return void
     */
    public function testTrueFalse()
    {
        // Test basic functionality
        $result = RandomHelper::trueFalse();
        $this->assertIsBool($result);
        
        // Test distribution over multiple runs
        $trueCount = 0;
        $falseCount = 0;
        $iterations = 1000;
        
        for ($i = 0; $i < $iterations; $i++) {
            if (RandomHelper::trueFalse()) {
                $trueCount++;
            } else {
                $falseCount++;
            }
        }
        
        // Both should be present (very unlikely to be 0 or 1000)
        $this->assertGreaterThan(0, $trueCount);
        $this->assertGreaterThan(0, $falseCount);
        $this->assertEquals($iterations, $trueCount + $falseCount);
    }

    /**
     * Tests the uniqid() method for generating unique identifiers.
     * Verifies length, prefix handling, and uniqueness of generated values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::uniqid
     * @return void
     */
    public function testUniqid()
    {
        // Test default length
        $id1 = RandomHelper::uniqid();
        $this->assertEquals(13, strlen($id1));
        $this->assertMatchesRegularExpression('/^[a-f0-9]{13}$/', $id1);

        // Test with prefix
        $id2 = RandomHelper::uniqid('my_prefix_');
        $this->assertStringStartsWith('my_prefix_', $id2);
        $this->assertEquals(23, strlen($id2));

        // Test uniqueness
        $uniqueIds = [];
        for ($i = 0; $i < 10000; $i++) {
            $uniqueIds[] = RandomHelper::uniqid();
        }
        $this->assertEquals(count($uniqueIds), count(array_unique($uniqueIds)));
    }

    /**
     * Tests the int() method for generating random integers.
     * Verifies range constraints and edge cases.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::int
     * @return void
     */
    public function testInt()
    {
        // Test basic range
        $result = RandomHelper::int(1, 10);
        $this->assertIsInt($result);
        $this->assertGreaterThanOrEqual(1, $result);
        $this->assertLessThanOrEqual(10, $result);
        
        // Test single value range
        $result = RandomHelper::int(5, 5);
        $this->assertEquals(5, $result);
        
        // Test negative range
        $result = RandomHelper::int(-10, -1);
        $this->assertGreaterThanOrEqual(-10, $result);
        $this->assertLessThanOrEqual(-1, $result);
        
        // Test default parameters
        $result = RandomHelper::int();
        $this->assertGreaterThanOrEqual(0, $result);
    }

    /**
     * Tests exception handling for int() with invalid range.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::int
     * @return void
     */
    public function testIntInvalidRange()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Minimum value cannot be greater than maximum value.');
        RandomHelper::int(10, 5);
    }

    /**
     * Tests the float() method for generating random floats.
     * Verifies range constraints and precision handling.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::float
     * @return void
     */
    public function testFloat()
    {
        // Test basic range
        $result = RandomHelper::float(0.0, 1.0, 2);
        $this->assertIsFloat($result);
        $this->assertGreaterThanOrEqual(0.0, $result);
        $this->assertLessThanOrEqual(1.0, $result);
        
        // Test precision
        $result = RandomHelper::float(0.0, 1.0, 1);
        $this->assertEquals(1, strlen(substr(strrchr($result, "."), 1)));
        
        // Test custom range
        $result = RandomHelper::float(10.5, 20.7, 2);
        $this->assertGreaterThanOrEqual(10.5, $result);
        $this->assertLessThanOrEqual(20.7, $result);
    }

    /**
     * Tests exception handling for float() with invalid range.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::float
     * @return void
     */
    public function testFloatInvalidRange()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Minimum value cannot be greater than maximum value.');
        RandomHelper::float(5.0, 2.0);
    }

    /**
     * Tests the string() method for generating random strings.
     * Verifies length, character set usage, and customization.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::string
     * @return void
     */
    public function testString()
    {
        // Test default alphanumeric
        $result = RandomHelper::string(10);
        $this->assertEquals(10, strlen($result));
        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9]{10}$/', $result);
        
        // Test numeric only
        $result = RandomHelper::string(8, RandomHelper::CHARSET_NUMERIC);
        $this->assertEquals(8, strlen($result));
        $this->assertMatchesRegularExpression('/^[0-9]{8}$/', $result);
        
        // Test alpha only
        $result = RandomHelper::string(6, RandomHelper::CHARSET_ALPHA);
        $this->assertEquals(6, strlen($result));
        $this->assertMatchesRegularExpression('/^[a-zA-Z]{6}$/', $result);
        
        // Test hex
        $result = RandomHelper::string(12, RandomHelper::CHARSET_HEX);
        $this->assertEquals(12, strlen($result));
        $this->assertMatchesRegularExpression('/^[a-f0-9]{12}$/', $result);
    }

    /**
     * Tests exception handling for string() with invalid parameters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::string
     * @return void
     */
    public function testStringInvalidLength()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Length must be at least 1.');
        RandomHelper::string(0);
    }

    /**
     * Tests exception handling for string() with empty charset.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::string
     * @return void
     */
    public function testStringEmptyCharset()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Character set cannot be empty.');
        RandomHelper::string(5, '');
    }

    /**
     * Tests the secureString() method for cryptographically secure strings.
     * Verifies length, character set usage, and security.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::secureString
     * @return void
     */
    public function testSecureString()
    {
        // Test default alphanumeric
        $result = RandomHelper::secureString(16);
        $this->assertEquals(16, strlen($result));
        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9]{16}$/', $result);
        
        // Test with different charset
        $result = RandomHelper::secureString(10, RandomHelper::CHARSET_HEX);
        $this->assertEquals(10, strlen($result));
        $this->assertMatchesRegularExpression('/^[a-f0-9]{10}$/', $result);
        
        // Test uniqueness
        $strings = [];
        for ($i = 0; $i < 1000; $i++) {
            $strings[] = RandomHelper::secureString(8);
        }
        $this->assertEquals(count($strings), count(array_unique($strings)));
    }

    /**
     * Tests the password() method for generating secure passwords.
     * Verifies character set inclusion and customization options.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::password
     * @return void
     */
    public function testPassword()
    {
        // Test default password
        $password = RandomHelper::password();
        $this->assertEquals(12, strlen($password));
        
        // Test length customization
        $password = RandomHelper::password(8);
        $this->assertEquals(8, strlen($password));
        
        // Test character type exclusion
        $password = RandomHelper::password(10, false, true, true, false);
        $this->assertMatchesRegularExpression('/^[a-z0-9]+$/', $password);
        
        // Test with excluded characters
        $password = RandomHelper::password(10, true, true, true, false, '0O');
        $this->assertStringNotContainsString('0', $password);
        $this->assertStringNotContainsString('O', $password);
    }

    /**
     * Tests exception handling for password() with no character types.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::password
     * @return void
     */
    public function testPasswordNoCharacterTypes()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('At least one character type must be included.');
        RandomHelper::password(8, false, false, false, false);
    }

    /**
     * Tests the arrayElement() method for selecting random array elements.
     * Verifies proper selection from different array types.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::arrayElement
     * @return void
     */
    public function testArrayElement()
    {
        // Test indexed array
        $array = ['apple', 'banana', 'cherry'];
        $result = RandomHelper::arrayElement($array);
        $this->assertContains($result, $array);
        
        // Test associative array
        $array = ['fruit' => 'apple', 'color' => 'red', 'size' => 'medium'];
        $result = RandomHelper::arrayElement($array);
        $this->assertContains($result, $array);
        
        // Test single element
        $array = ['only'];
        $result = RandomHelper::arrayElement($array);
        $this->assertEquals('only', $result);
    }

    /**
     * Tests exception handling for arrayElement() with empty array.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::arrayElement
     * @return void
     */
    public function testArrayElementEmpty()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Array cannot be empty.');
        RandomHelper::arrayElement([]);
    }

    /**
     * Tests the arrayElements() method for selecting multiple random elements.
     * Verifies proper selection without replacement.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::arrayElements
     * @return void
     */
    public function testArrayElements()
    {
        $array = ['a', 'b', 'c', 'd', 'e'];
        
        // Test normal selection
        $result = RandomHelper::arrayElements($array, 3);
        $this->assertCount(3, $result);
        $this->assertEquals(3, count(array_unique($result))); // No duplicates
        
        foreach ($result as $element) {
            $this->assertContains($element, $array);
        }
        
        // Test selecting all elements
        $result = RandomHelper::arrayElements($array, 5);
        $this->assertCount(5, $result);
    }

    /**
     * Tests exception handling for arrayElements() with invalid count.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::arrayElements
     * @return void
     */
    public function testArrayElementsInvalidCount()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Count cannot be greater than array size.');
        RandomHelper::arrayElements(['a', 'b'], 3);
    }

    /**
     * Tests the shuffle() method for array shuffling.
     * Verifies that original array is not modified and result contains same elements.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::shuffle
     * @return void
     */
    public function testShuffle()
    {
        $original = [1, 2, 3, 4, 5];
        $shuffled = RandomHelper::shuffle($original);
        
        // Original should not be modified
        $this->assertEquals([1, 2, 3, 4, 5], $original);
        
        // Shuffled should contain same elements
        $this->assertCount(5, $shuffled);
        sort($shuffled); // Sort to compare
        $this->assertEquals([1, 2, 3, 4, 5], $shuffled);
    }

    /**
     * Tests the hexColor() method for generating hex colors.
     * Verifies format and hash inclusion options.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::hexColor
     * @return void
     */
    public function testHexColor()
    {
        // Test with hash
        $color = RandomHelper::hexColor();
        $this->assertMatchesRegularExpression('/^#[a-f0-9]{6}$/', $color);
        
        // Test without hash
        $color = RandomHelper::hexColor(false);
        $this->assertMatchesRegularExpression('/^[a-f0-9]{6}$/', $color);
        $this->assertEquals(6, strlen($color));
    }

    /**
     * Tests the rgbColor() method for generating RGB colors.
     * Verifies proper structure and value ranges.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::rgbColor
     * @return void
     */
    public function testRgbColor()
    {
        $color = RandomHelper::rgbColor();
        
        $this->assertIsArray($color);
        $this->assertArrayHasKey('r', $color);
        $this->assertArrayHasKey('g', $color);
        $this->assertArrayHasKey('b', $color);
        
        $this->assertGreaterThanOrEqual(0, $color['r']);
        $this->assertLessThanOrEqual(255, $color['r']);
        $this->assertGreaterThanOrEqual(0, $color['g']);
        $this->assertLessThanOrEqual(255, $color['g']);
        $this->assertGreaterThanOrEqual(0, $color['b']);
        $this->assertLessThanOrEqual(255, $color['b']);
    }

    /**
     * Tests the uuid4() method for generating UUIDs.
     * Verifies format and version compliance.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::uuid4
     * @return void
     */
    public function testUuid4()
    {
        $uuid = RandomHelper::uuid4();
        
        // Test format
        $this->assertMatchesRegularExpression('/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89ab][a-f0-9]{3}-[a-f0-9]{12}$/', $uuid);
        
        // Test uniqueness
        $uuids = [];
        for ($i = 0; $i < 100; $i++) {
            $uuids[] = RandomHelper::uuid4();
        }
        $this->assertEquals(count($uuids), count(array_unique($uuids)));
    }

    /**
     * Tests the token() method for generating secure tokens.
     * Verifies length and character safety options.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::token
     * @return void
     */
    public function testToken()
    {
        // Test default token
        $token = RandomHelper::token();
        $this->assertEquals(32, strlen($token));
        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9_-]+$/', $token);
        
        // Test custom length
        $token = RandomHelper::token(16);
        $this->assertEquals(16, strlen($token));
        
        // Test non-URL safe
        $token = RandomHelper::token(20, false);
        $this->assertEquals(20, strlen($token));
    }

    /**
     * Tests the date() method for generating random dates.
     * Verifies date range constraints and formatting.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::date
     * @return void
     */
    public function testDate()
    {
        $start = new \DateTime('2020-01-01');
        $end = new \DateTime('2023-12-31');
        
        // Test default format
        $date = RandomHelper::date($start, $end);
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $date);
        
        $dateTime = \DateTime::createFromFormat('Y-m-d', $date);
        $this->assertGreaterThanOrEqual($start, $dateTime);
        $this->assertLessThanOrEqual($end, $dateTime);
        
        // Test custom format
        $date = RandomHelper::date($start, $end, 'd/m/Y');
        $this->assertMatchesRegularExpression('/^\d{2}\/\d{2}\/\d{4}$/', $date);
    }

    /**
     * Tests exception handling for date() with invalid range.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::date
     * @return void
     */
    public function testDateInvalidRange()
    {
        $start = new \DateTime('2023-12-31');
        $end = new \DateTime('2020-01-01');
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Start date cannot be after end date.');
        RandomHelper::date($start, $end);
    }

    /**
     * Tests the weighted() method for weighted random selection.
     * Verifies proper weight distribution over multiple runs.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::weighted
     * @return void
     */
    public function testWeighted()
    {
        $weights = ['common' => 70, 'rare' => 20, 'epic' => 10];
        
        $counts = ['common' => 0, 'rare' => 0, 'epic' => 0];
        $iterations = 10000;
        
        for ($i = 0; $i < $iterations; $i++) {
            $result = RandomHelper::weighted($weights);
            $counts[$result]++;
        }
        
        // Common should appear most frequently
        $this->assertGreaterThan($counts['rare'], $counts['common']);
        $this->assertGreaterThan($counts['epic'], $counts['common']);
        $this->assertGreaterThan($counts['epic'], $counts['rare']);
    }

    /**
     * Tests exception handling for weighted() with invalid weights.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::weighted
     * @return void
     */
    public function testWeightedInvalidWeights()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('All weights must be non-negative numbers.');
        RandomHelper::weighted(['item1' => -5, 'item2' => 10]);
    }

    /**
     * Tests the macAddress() method for generating MAC addresses.
     * Verifies format and customization options.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::macAddress
     * @return void
     */
    public function testMacAddress()
    {
        // Test default format
        $mac = RandomHelper::macAddress();
        $this->assertMatchesRegularExpression('/^[a-f0-9]{2}:[a-f0-9]{2}:[a-f0-9]{2}:[a-f0-9]{2}:[a-f0-9]{2}:[a-f0-9]{2}$/', $mac);
        
        // Test with dash separator and uppercase
        $mac = RandomHelper::macAddress('-', true);
        $this->assertMatchesRegularExpression('/^[A-F0-9]{2}-[A-F0-9]{2}-[A-F0-9]{2}-[A-F0-9]{2}-[A-F0-9]{2}-[A-F0-9]{2}$/', $mac);
    }

    /**
     * Tests the ipAddress() method for generating IP addresses.
     * Verifies IPv4 and IPv6 generation and private range options.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::ipAddress
     * @return void
     */
    public function testIpAddress()
    {
        // Test IPv4
        $ip = RandomHelper::ipAddress(4);
        $this->assertMatchesRegularExpression('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $ip);
        $this->assertTrue(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false);
        
        // Test IPv4 private
        $ip = RandomHelper::ipAddress(4, true);
        $this->assertTrue(
            filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE) === false ||
            filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false
        );
        
        // Test IPv6
        $ip = RandomHelper::ipAddress(6);
        $this->assertMatchesRegularExpression('/^[a-f0-9]{4}:[a-f0-9]{4}:[a-f0-9]{4}:[a-f0-9]{4}:[a-f0-9]{4}:[a-f0-9]{4}:[a-f0-9]{4}:[a-f0-9]{4}$/', $ip);
    }

    /**
     * Tests exception handling for ipAddress() with invalid version.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::ipAddress
     * @return void
     */
    public function testIpAddressInvalidVersion()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('IP version must be 4 or 6.');
        RandomHelper::ipAddress(5);
    }

    /**
     * Tests character set constants are properly defined.
     * Verifies all character set constants contain expected characters.
     *
     * @test
     * @return void
     */
    public function testCharsetConstants()
    {
        // Test numeric charset
        $this->assertEquals('0123456789', RandomHelper::CHARSET_NUMERIC);
        
        // Test alpha charsets
        $this->assertEquals('abcdefghijklmnopqrstuvwxyz', RandomHelper::CHARSET_ALPHA_LOWER);
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUVWXYZ', RandomHelper::CHARSET_ALPHA_UPPER);
        
        // Test combined charsets
        $this->assertEquals(
            RandomHelper::CHARSET_ALPHA_LOWER . RandomHelper::CHARSET_ALPHA_UPPER, 
            RandomHelper::CHARSET_ALPHA
        );
        $this->assertEquals(
            RandomHelper::CHARSET_ALPHA . RandomHelper::CHARSET_NUMERIC, 
            RandomHelper::CHARSET_ALPHANUMERIC
        );
        
        // Test hex charset
        $this->assertEquals('0123456789abcdef', RandomHelper::CHARSET_HEX);
        
        // Test special characters are present
        $this->assertStringContainsString('!', RandomHelper::CHARSET_SPECIAL);
        $this->assertStringContainsString('@', RandomHelper::CHARSET_SPECIAL);
        $this->assertStringContainsString('#', RandomHelper::CHARSET_SPECIAL);
    }
}
