<?php

namespace AndreasGlaser\Helpers\Tests\String;

use AndreasGlaser\Helpers\StringHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * StringHelperTest provides unit tests for the StringHelper class.
 *
 * This class tests string manipulation and comparison methods:
 * - String comparison (is, isOneOf)
 * - String content checking (contains, startsWith, endsWith)
 * - String trimming (trimMulti, rTrimMulti, lTrimMulti)
 * - String generation (getIncrementalId)
 * - String validation (isDateTime, isBlank)
 * - String modification (removeFromStart, removeFromEnd)
 * - String conversion (linesToArray)
 */
class StringHelperTest extends BaseTest
{
    /**
     * @var string The test string used across multiple test methods
     */
    protected $testString = 'Hello there, this is a test string.';

    /**
     * Tests the is() method for exact string comparison with case sensitivity option.
     */
    public function testIs()
    {
        self::assertTrue(StringHelper::is($this->testString, 'Hello there, this is a test string.', true));
        self::assertFalse(StringHelper::is($this->testString, 'Hello there, this is test string.', true));
        self::assertTrue(StringHelper::is($this->testString, 'HELLO there, this is a TEST string.', false));
    }

    /**
     * Tests the isOneOf() method for checking if a string matches any in an array with case sensitivity option.
     */
    public function testIsOneOf()
    {
        self::assertTrue(StringHelper::isOneOf($this->testString, ['Hello there, this is a test string.', 'cheese'], true));
        self::assertFalse(StringHelper::isOneOf($this->testString, ['Hell', 'cheese'], true));
        self::assertTrue(StringHelper::isOneOf($this->testString, ['Hello there, THIS is a test string.', 'cheese'], false));
    }

    /**
     * Tests the contains() method for checking if a string contains a substring with case sensitivity option.
     */
    public function testContains()
    {
        self::assertTrue(StringHelper::contains($this->testString, 'this is', true));
        self::assertFalse(StringHelper::contains($this->testString, 'strng', true));
        self::assertTrue(StringHelper::contains($this->testString, 'STRING.', false));
    }

    /**
     * Tests the startsWith() method for checking if a string starts with a prefix with case sensitivity option.
     */
    public function testStringStartsWith()
    {
        self::assertTrue(StringHelper::startsWith($this->testString, 'Hello', true));
        self::assertFalse(StringHelper::startsWith($this->testString, 'Hellu', true));
        self::assertTrue(StringHelper::startsWith($this->testString, 'HELLO', false));

        // strings always "start" with null/nothing
        self::assertTrue(StringHelper::startsWith($this->testString, null, true));
        self::assertTrue(StringHelper::startsWith($this->testString, null, false));
    }

    /**
     * Tests the endsWith() method for checking if a string ends with a suffix with case sensitivity option.
     */
    public function testStringEndsWith()
    {
        self::assertTrue(StringHelper::endsWith($this->testString, 'string.', true));
        self::assertFalse(StringHelper::endsWith($this->testString, 'string!', true));
        self::assertTrue(StringHelper::endsWith($this->testString, 'STRING.', false));

        // strings always "end" with null/nothing
        self::assertTrue(StringHelper::endsWith($this->testString, null, true));
        self::assertTrue(StringHelper::endsWith($this->testString, null, false));
    }

    /**
     * Tests the trimMulti() method for removing multiple characters from both ends of a string.
     */
    public function testTrimMulti()
    {
        self::assertEquals(' there, this is a test string', StringHelper::trimMulti($this->testString, ['Hello', '.']));
        self::assertNotEquals(' there, this is a test string', StringHelper::trimMulti($this->testString, ['Hello', ',']));
    }

    /**
     * Tests the rTrimMulti() method for removing multiple characters from the right end of a string.
     */
    public function testRTrimMulti()
    {
        self::assertEquals(' there, this is a test string.', StringHelper::lTrimMulti($this->testString, ['Hello']));
        self::assertNotEquals('there, this is a test string.', StringHelper::lTrimMulti($this->testString, ['Hello', ',']));
    }

    /**
     * Tests the lTrimMulti() method for removing multiple characters from the left end of a string.
     */
    public function testLTrimMulti()
    {
        self::assertEquals('Hello there, this is a test ', StringHelper::rTrimMulti($this->testString, ['.', 'string']));
        self::assertNotEquals('Hello there, this is a test string!', StringHelper::rTrimMulti($this->testString, ['.']));
    }

    /**
     * Tests the getIncrementalId() method for generating sequential IDs with optional prefix.
     */
    public function testGetIncrementalId()
    {
        self::assertEquals(0, StringHelper::getIncrementalId());
        self::assertEquals(1, StringHelper::getIncrementalId());
        self::assertEquals(2, StringHelper::getIncrementalId());
        self::assertEquals(3, StringHelper::getIncrementalId());
        self::assertEquals(4, StringHelper::getIncrementalId());

        self::assertEquals('prefix_0', StringHelper::getIncrementalId('prefix_'));
        self::assertEquals('prefix_1', StringHelper::getIncrementalId('prefix_'));
        self::assertEquals('prefix_2', StringHelper::getIncrementalId('prefix_'));
    }

    /**
     * Tests the isDateTime() method for validating various datetime string formats.
     */
    public function testIsDateTime()
    {
        self::assertTrue(StringHelper::isDateTime('2015-03-23'));
        self::assertTrue(StringHelper::isDateTime('2015-03-23 22:21'));
        self::assertTrue(StringHelper::isDateTime('5pm'));
        self::assertTrue(StringHelper::isDateTime('+8 Weeks'));

        self::assertFalse(StringHelper::isDateTime('2015-13-23 22:21'));
        self::assertFalse(StringHelper::isDateTime('2015-12-23 25:21'));
        self::assertFalse(StringHelper::isDateTime('N/A'));
        self::assertFalse(StringHelper::isDateTime(null));
        self::assertFalse(StringHelper::isDateTime(''));
    }

    /**
     * Tests the isBlank() method for checking if a string is empty or contains only whitespace.
     */
    public function testIsBlank()
    {
        self::assertTrue(StringHelper::isBlank(' '));
        self::assertTrue(StringHelper::isBlank('   '));
        self::assertTrue(StringHelper::isBlank(null));
        self::assertFalse(StringHelper::isBlank('a'));
        self::assertFalse(StringHelper::isBlank(' a  '));
        self::assertFalse(StringHelper::isBlank(0));
    }

    /**
     * Tests the removeFromStart() method for removing a prefix from a string with case sensitivity option.
     */
    public function testRemoveFromStart()
    {
        self::assertEquals(' is a string', StringHelper::removeFromStart('this is a string', 'this'));
        self::assertEquals('this is a string', StringHelper::removeFromStart('this is a string', 'This'));
        self::assertEquals(' is a string', StringHelper::removeFromStart('this is a string', 'This', false));
        self::assertEquals('this is a string', StringHelper::removeFromStart('this is a string', 'XYZ'));
    }

    /**
     * Tests the removeFromEnd() method for removing a suffix from a string with case sensitivity option.
     */
    public function testRemoveFromEnd()
    {
        self::assertEquals('this is a ', StringHelper::removeFromEnd('this is a string', 'string'));
        self::assertEquals('this is a string', StringHelper::removeFromEnd('this is a string', 'String'));
        self::assertEquals('this is a ', StringHelper::removeFromEnd('this is a string', 'String', false));
        self::assertEquals('this is a string', StringHelper::removeFromEnd('this is a string', 'XYZ'));
    }

    /**
     * Tests the linesToArray() method for converting a string with line breaks into an array of lines.
     */
    public function testLinesToArray()
    {
        $testString = "Line1\nLine2\rLine3\r\nLine4";

        $lines = StringHelper::linesToArray($testString);

        self::assertCount(4, $lines);
        self::assertEquals('Line1', $lines[0]);
        self::assertEquals('Line2', $lines[1]);
        self::assertEquals('Line3', $lines[2]);
        self::assertEquals('Line4', $lines[3]);
    }
}
