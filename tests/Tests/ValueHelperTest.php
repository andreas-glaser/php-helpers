<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\ValueHelper;

/**
 * Class ValueHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests
 * @author  Andreas Glaser
 */
class ValueHelperTest extends BaseTest
{
    /**
     * @author Andreas Glaser
     */
    public function testEmptyToNull()
    {
        $nullValues = [
            '',
            0,
            0.0,
            '0',
            null,
            false,
            [],
        ];

        foreach ($nullValues AS $value) {
            $this->assertNull(ValueHelper::emptyToNull($value));
        }

        $noneNullValues = [
            '1',
            1,
            0.2,
            true,
            ['abc'],
        ];

        foreach ($noneNullValues AS $value) {
            $this->assertNotNull(ValueHelper::emptyToNull($value));
        }
    }

    /**
     * @author Andreas Glaser
     */
    public function testIsEmpty()
    {
        $this->assertTrue(ValueHelper::isEmpty(''));
        $this->assertTrue(ValueHelper::isEmpty('0'));
        $this->assertTrue(ValueHelper::isEmpty(0));
        $this->assertTrue(ValueHelper::isEmpty(0.0));
        $this->assertTrue(ValueHelper::isEmpty(null));
        $this->assertTrue(ValueHelper::isEmpty(false));
        $this->assertTrue(ValueHelper::isEmpty([]));

        $this->assertFalse(ValueHelper::isEmpty(' '));
        $this->assertFalse(ValueHelper::isEmpty('1'));
        $this->assertFalse(ValueHelper::isEmpty(1));
        $this->assertFalse(ValueHelper::isEmpty(0.1));
        $this->assertFalse(ValueHelper::isEmpty(true));
        $this->assertFalse(ValueHelper::isEmpty([0]));
    }

    /**
     * @author Andreas Glaser
     */
    public function testIsInteger()
    {
        $this->assertTrue(ValueHelper::isInteger(1));
        $this->assertTrue(ValueHelper::isInteger('1'));
        $this->assertFalse(ValueHelper::isInteger(1.3));
        $this->assertFalse(ValueHelper::isInteger('1.0'));
        $this->assertFalse(ValueHelper::isInteger(''));
        $this->assertFalse(ValueHelper::isInteger(null));
        $this->assertFalse(ValueHelper::isInteger([]));
        $this->assertFalse(ValueHelper::isInteger(false));
        $this->assertFalse(ValueHelper::isInteger(true));
    }

    /**
     * @author Andreas Glaser
     */
    public function testIsFloat()
    {
        $this->assertTrue(ValueHelper::isFloat(1.0));
        $this->assertTrue(ValueHelper::isFloat('1.0'));
        $this->assertFalse(ValueHelper::isFloat(1));
        $this->assertFalse(ValueHelper::isFloat('1'));
        $this->assertFalse(ValueHelper::isFloat(''));
        $this->assertFalse(ValueHelper::isFloat(null));
        $this->assertFalse(ValueHelper::isFloat([]));
        $this->assertFalse(ValueHelper::isFloat(false));
        $this->assertFalse(ValueHelper::isFloat(true));
    }

    /**
     * @author Andreas Glaser
     */
    public function testIsDateTime()
    {
        $this->assertTrue(ValueHelper::isDateTime('2015-03-23'));
        $this->assertTrue(ValueHelper::isDateTime('2015-03-23 22:21'));
        $this->assertTrue(ValueHelper::isDateTime('5pm'));
        $this->assertTrue(ValueHelper::isDateTime('+8 Weeks'));

        $this->assertFalse(ValueHelper::isDateTime('2015-13-23 22:21'));
        $this->assertFalse(ValueHelper::isDateTime('2015-12-23 25:21'));
        $this->assertFalse(ValueHelper::isDateTime('N/A'));
        $this->assertFalse(ValueHelper::isDateTime(null));
        $this->assertFalse(ValueHelper::isDateTime(''));
    }

    /**
     * @author Andreas Glaser
     */
    public function testIsBool()
    {
        $this->assertTrue(ValueHelper::isBool(true));
        $this->assertTrue(ValueHelper::isBool(false));
        $this->assertFalse(ValueHelper::isBool(''));
        $this->assertFalse(ValueHelper::isBool(null));
        $this->assertFalse(ValueHelper::isBool([]));
        $this->assertFalse(ValueHelper::isBool(new \stdClass()));
    }

    /**
     * @author Andreas Glaser
     */
    public function testIsTrue()
    {
        $this->assertTrue(ValueHelper::isTrue(true));
        $this->assertFalse(ValueHelper::isTrue(false));
        $this->assertFalse(ValueHelper::isTrue(1));
        $this->assertFalse(ValueHelper::isTrue(''));
        $this->assertFalse(ValueHelper::isTrue(null));
        $this->assertFalse(ValueHelper::isTrue([]));
        $this->assertFalse(ValueHelper::isTrue(new \stdClass()));
    }

    /**
     * @author Andreas Glaser
     */
    public function testIsFalse()
    {
        $this->assertTrue(ValueHelper::isFalse(false));
        $this->assertFalse(ValueHelper::isFalse(true));
        $this->assertFalse(ValueHelper::isTrue(0));
        $this->assertFalse(ValueHelper::isFalse(''));
        $this->assertFalse(ValueHelper::isFalse(null));
        $this->assertFalse(ValueHelper::isFalse([]));
        $this->assertFalse(ValueHelper::isFalse(new \stdClass()));
    }

    /**
     * @author Andreas Glaser
     */
    public function testIsTrueLike()
    {
        $this->assertTrue(ValueHelper::isTrueLike(true));
        $this->assertTrue(ValueHelper::isTrueLike(1));
        $this->assertTrue(ValueHelper::isTrueLike(1.1));
        $this->assertTrue(ValueHelper::isTrueLike('1'));
        $this->assertTrue(ValueHelper::isTrueLike('abc'));
        $this->assertTrue(ValueHelper::isTrueLike(new \stdClass()));
        $this->assertFalse(ValueHelper::isTrueLike(false));
        $this->assertFalse(ValueHelper::isTrueLike(''));
        $this->assertFalse(ValueHelper::isTrueLike(null));
        $this->assertFalse(ValueHelper::isTrueLike([]));
    }

    /**
     * @author Andreas Glaser
     */
    public function testIsFalseLike()
    {
        $this->assertTrue(ValueHelper::isFalseLike(false));
        $this->assertTrue(ValueHelper::isFalseLike(0));
        $this->assertTrue(ValueHelper::isFalseLike(0.0));
        $this->assertTrue(ValueHelper::isFalseLike('0'));
        $this->assertTrue(ValueHelper::isFalseLike(null));
        $this->assertTrue(ValueHelper::isFalseLike([]));
        $this->assertFalse(ValueHelper::isFalseLike(1));
        $this->assertFalse(ValueHelper::isFalseLike('abc'));
        $this->assertFalse(ValueHelper::isFalseLike(new \stdClass()));
        $this->assertFalse(ValueHelper::isFalseLike(true));
        $this->assertFalse(ValueHelper::isFalseLike(' '));
    }
}