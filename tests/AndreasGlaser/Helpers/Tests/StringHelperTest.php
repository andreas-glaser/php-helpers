<?php

namespace AndreasGlaser\Helpers\Test;

use AndreasGlaser\Helpers\StringHelper;

/**
 * Class StringHelperTest
 *
 * @package Helpers\Test
 *
 * @author  Andreas Glaser
 */
class StringHelperTest extends \PHPUnit_Framework_TestCase
{
    protected $testString = 'Hello there, this is a test string.';

    public function testMatches()
    {
        $this->assertTrue(StringHelper::is($this->testString, 'Hello there, this is a test string.', true));
        $this->assertFalse(StringHelper::is($this->testString, 'Hello there, this is test string.', true));
        $this->assertTrue(StringHelper::is($this->testString, 'HELLO there, this is a TEST string.', false));
    }

    public function testMatchesOneOf()
    {
        $this->assertEquals('Hello there, this is a test string.', StringHelper::isOneOf($this->testString, ['Hello there, this is a test string.', 'cheese'], true));
        $this->assertFalse(StringHelper::isOneOf($this->testString, ['Hell', 'cheese'], true));
        $this->assertEquals('Hello there, THIS is a test string.', StringHelper::isOneOf($this->testString, ['Hello there, THIS is a test string.', 'cheese'], false));
    }

    public function testContains()
    {
        $this->assertTrue(StringHelper::contains($this->testString, 'this is', true));
        $this->assertFalse(StringHelper::contains($this->testString, 'strng', true));
        $this->assertTrue(StringHelper::contains($this->testString, 'STRING.', false));
    }

    public function testStringStartsWith()
    {
        $this->assertTrue(StringHelper::startsWith($this->testString, 'Hello', true));
        $this->assertFalse(StringHelper::startsWith($this->testString, 'Hellu', true));
        $this->assertTrue(StringHelper::startsWith($this->testString, 'HELLO', false));

        // strings always "start" with null/nothing
        $this->assertTrue(StringHelper::startsWith($this->testString, null, true));
        $this->assertTrue(StringHelper::startsWith($this->testString, null, false));
    }

    public function testStringEndsWith()
    {
        $this->assertTrue(StringHelper::endsWith($this->testString, 'string.', true));
        $this->assertFalse(StringHelper::endsWith($this->testString, 'string!', true));
        $this->assertTrue(StringHelper::endsWith($this->testString, 'STRING.', false));

        // strings always "end" with null/nothing
        $this->assertTrue(StringHelper::endsWith($this->testString, null, true));
        $this->assertTrue(StringHelper::endsWith($this->testString, null, false));
    }

    public function testTrimMulti()
    {
        $this->assertEquals(' there, this is a test string', StringHelper::trimMulti($this->testString, ['Hello', '.']));
        $this->assertNotEquals(' there, this is a test string', StringHelper::trimMulti($this->testString, ['Hello', ',']));
    }

    public function testRTrimMulti()
    {
        $this->assertEquals(' there, this is a test string.', StringHelper::lTrimMulti($this->testString, ['Hello']));
        $this->assertNotEquals('there, this is a test string.', StringHelper::lTrimMulti($this->testString, ['Hello', ',']));
    }

    public function testLTrimMulti()
    {
        $this->assertEquals('Hello there, this is a test ', StringHelper::rTrimMulti($this->testString, ['.', 'string']));
        $this->assertNotEquals('Hello there, this is a test string!', StringHelper::rTrimMulti($this->testString, ['.']));
    }

    public function testGetIncrementalId()
    {
        $this->assertEquals(0, StringHelper::getIncrementalId());
        $this->assertEquals(1, StringHelper::getIncrementalId());
        $this->assertEquals(2, StringHelper::getIncrementalId());
        $this->assertEquals(3, StringHelper::getIncrementalId());
        $this->assertEquals(4, StringHelper::getIncrementalId());

        $this->assertEquals('prefix_0', StringHelper::getIncrementalId('prefix_'));
        $this->assertEquals('prefix_1', StringHelper::getIncrementalId('prefix_'));
        $this->assertEquals('prefix_2', StringHelper::getIncrementalId('prefix_'));
    }
}
 