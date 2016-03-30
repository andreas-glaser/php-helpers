<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\StringHelper;

/**
 * Class StringHelperTest
 *
 * @package Helpers\Tests
 *
 * @author  Andreas Glaser
 */
class StringHelperTest extends BaseTest
{
    /**
     * @var string
     */
    protected $testString = 'Hello there, this is a test string.';

    /**
     * @author Andreas Glaser
     */
    public function testIs()
    {
        $this->assertTrue(StringHelper::is($this->testString, 'Hello there, this is a test string.', true));
        $this->assertFalse(StringHelper::is($this->testString, 'Hello there, this is test string.', true));
        $this->assertTrue(StringHelper::is($this->testString, 'HELLO there, this is a TEST string.', false));
    }

    /**
     * @author Andreas Glaser
     */
    public function testIsOneOf()
    {
        $this->assertTrue(StringHelper::isOneOf($this->testString, ['Hello there, this is a test string.', 'cheese'], true));
        $this->assertFalse(StringHelper::isOneOf($this->testString, ['Hell', 'cheese'], true));
        $this->assertTrue(StringHelper::isOneOf($this->testString, ['Hello there, THIS is a test string.', 'cheese'], false));
    }

    /**
     * @author Andreas Glaser
     */
    public function testContains()
    {
        $this->assertTrue(StringHelper::contains($this->testString, 'this is', true));
        $this->assertFalse(StringHelper::contains($this->testString, 'strng', true));
        $this->assertTrue(StringHelper::contains($this->testString, 'STRING.', false));
    }

    /**
     * @author Andreas Glaser
     */
    public function testStringStartsWith()
    {
        $this->assertTrue(StringHelper::startsWith($this->testString, 'Hello', true));
        $this->assertFalse(StringHelper::startsWith($this->testString, 'Hellu', true));
        $this->assertTrue(StringHelper::startsWith($this->testString, 'HELLO', false));

        // strings always "start" with null/nothing
        $this->assertTrue(StringHelper::startsWith($this->testString, null, true));
        $this->assertTrue(StringHelper::startsWith($this->testString, null, false));
    }

    /**
     * @author Andreas Glaser
     */
    public function testStringEndsWith()
    {
        $this->assertTrue(StringHelper::endsWith($this->testString, 'string.', true));
        $this->assertFalse(StringHelper::endsWith($this->testString, 'string!', true));
        $this->assertTrue(StringHelper::endsWith($this->testString, 'STRING.', false));

        // strings always "end" with null/nothing
        $this->assertTrue(StringHelper::endsWith($this->testString, null, true));
        $this->assertTrue(StringHelper::endsWith($this->testString, null, false));
    }

    /**
     * @author Andreas Glaser
     */
    public function testTrimMulti()
    {
        $this->assertEquals(' there, this is a test string', StringHelper::trimMulti($this->testString, ['Hello', '.']));
        $this->assertNotEquals(' there, this is a test string', StringHelper::trimMulti($this->testString, ['Hello', ',']));
    }

    /**
     * @author Andreas Glaser
     */
    public function testRTrimMulti()
    {
        $this->assertEquals(' there, this is a test string.', StringHelper::lTrimMulti($this->testString, ['Hello']));
        $this->assertNotEquals('there, this is a test string.', StringHelper::lTrimMulti($this->testString, ['Hello', ',']));
    }

    /**
     * @author Andreas Glaser
     */
    public function testLTrimMulti()
    {
        $this->assertEquals('Hello there, this is a test ', StringHelper::rTrimMulti($this->testString, ['.', 'string']));
        $this->assertNotEquals('Hello there, this is a test string!', StringHelper::rTrimMulti($this->testString, ['.']));
    }

    /**
     * @author Andreas Glaser
     */
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

    /**
     * @author Andreas Glaser
     */
    public function testIsDateTime()
    {
        $this->assertTrue(StringHelper::isDateTime('2015-03-23'));
        $this->assertTrue(StringHelper::isDateTime('2015-03-23 22:21'));
        $this->assertTrue(StringHelper::isDateTime('5pm'));
        $this->assertTrue(StringHelper::isDateTime('+8 Weeks'));

        $this->assertFalse(StringHelper::isDateTime('2015-13-23 22:21'));
        $this->assertFalse(StringHelper::isDateTime('2015-12-23 25:21'));
        $this->assertFalse(StringHelper::isDateTime('N/A'));
        $this->assertFalse(StringHelper::isDateTime(null));
        $this->assertFalse(StringHelper::isDateTime(''));
    }

    /**
     * @author Andreas Glaser
     */
    public function testIsBlank()
    {
        $this->assertTrue(StringHelper::isBlank(' '));
        $this->assertTrue(StringHelper::isBlank('   '));
        $this->assertTrue(StringHelper::isBlank(null));
        $this->assertFalse(StringHelper::isBlank('a'));
        $this->assertFalse(StringHelper::isBlank(' a  '));
        $this->assertFalse(StringHelper::isBlank(0));
    }
}
 