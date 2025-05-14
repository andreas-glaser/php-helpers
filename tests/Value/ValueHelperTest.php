<?php

namespace AndreasGlaser\Helpers\Tests\Value;

use AndreasGlaser\Helpers\ValueHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * ValueHelperTest provides unit tests for the ValueHelper class.
 *
 * This class tests value validation and type checking functionality:
 * - Empty value detection and conversion
 * - Type validation (integer, float, boolean, datetime)
 * - Truthiness checking (true, false, true-like, false-like)
 */
class ValueHelperTest extends BaseTest
{
    /**
     * Tests the emptyToNull() method for converting empty values to null.
     * 
     * Tests various empty values:
     * - Empty strings
     * - Zero values
     * - Null
     * - False
     * - Empty arrays
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

        foreach ($nullValues as $value) {
            self::assertNull(ValueHelper::emptyToNull($value));
        }

        $noneNullValues = [
            '1',
            1,
            0.2,
            true,
            ['abc'],
        ];

        foreach ($noneNullValues as $value) {
            self::assertNotNull(ValueHelper::emptyToNull($value));
        }
    }

    /**
     * Tests the isEmpty() method for checking if values are empty.
     * 
     * Tests various values:
     * - Empty values
     * - Non-empty values
     * - Edge cases
     */
    public function testIsEmpty()
    {
        self::assertTrue(ValueHelper::isEmpty(''));
        self::assertTrue(ValueHelper::isEmpty('0'));
        self::assertTrue(ValueHelper::isEmpty(0));
        self::assertTrue(ValueHelper::isEmpty(0.0));
        self::assertTrue(ValueHelper::isEmpty(null));
        self::assertTrue(ValueHelper::isEmpty(false));
        self::assertTrue(ValueHelper::isEmpty([]));

        self::assertFalse(ValueHelper::isEmpty(' '));
        self::assertFalse(ValueHelper::isEmpty('1'));
        self::assertFalse(ValueHelper::isEmpty(1));
        self::assertFalse(ValueHelper::isEmpty(0.1));
        self::assertFalse(ValueHelper::isEmpty(true));
        self::assertFalse(ValueHelper::isEmpty([0]));
    }

    /**
     * Tests the isInteger() method for integer type validation.
     * 
     * Tests:
     * - Integer values
     * - String representations of integers
     * - Non-integer values
     */
    public function testIsInteger()
    {
        self::assertTrue(ValueHelper::isInteger(1));
        self::assertTrue(ValueHelper::isInteger('1'));
        self::assertFalse(ValueHelper::isInteger(1.3));
        self::assertFalse(ValueHelper::isInteger('1.0'));
        self::assertFalse(ValueHelper::isInteger(''));
        self::assertFalse(ValueHelper::isInteger(null));
        self::assertFalse(ValueHelper::isInteger([]));
        self::assertFalse(ValueHelper::isInteger(false));
        self::assertFalse(ValueHelper::isInteger(true));
    }

    /**
     * Tests the isFloat() method for float type validation.
     * 
     * Tests:
     * - Float values
     * - String representations of floats
     * - Non-float values
     */
    public function testIsFloat()
    {
        self::assertTrue(ValueHelper::isFloat(1.0));
        self::assertTrue(ValueHelper::isFloat('1.0'));
        self::assertFalse(ValueHelper::isFloat(1));
        self::assertFalse(ValueHelper::isFloat('1'));
        self::assertFalse(ValueHelper::isFloat(''));
        self::assertFalse(ValueHelper::isFloat(null));
        self::assertFalse(ValueHelper::isFloat([]));
        self::assertFalse(ValueHelper::isFloat(false));
        self::assertFalse(ValueHelper::isFloat(true));
    }

    /**
     * Tests the isDateTime() method for datetime validation.
     * 
     * Tests:
     * - Various date formats
     * - Relative time expressions
     * - Invalid dates
     * - DateTime objects
     * - Custom format validation
     */
    public function testIsDateTime()
    {
        self::assertTrue(ValueHelper::isDateTime('2015-03-23'));
        self::assertTrue(ValueHelper::isDateTime('2015-03-23 22:21'));
        self::assertTrue(ValueHelper::isDateTime('5pm'));
        self::assertTrue(ValueHelper::isDateTime('+8 Weeks'));

        self::assertFalse(ValueHelper::isDateTime('2015-00-00'));
        self::assertFalse(ValueHelper::isDateTime('2015-00-00 00:00:00'));
        self::assertFalse(ValueHelper::isDateTime('2015-13-23 22:21'));
        self::assertFalse(ValueHelper::isDateTime('2015-12-23 25:21'));
        self::assertFalse(ValueHelper::isDateTime('N/A'));
        self::assertFalse(ValueHelper::isDateTime(null));
        self::assertFalse(ValueHelper::isDateTime(''));
        self::assertFalse(ValueHelper::isDateTime('    '));

        self::assertTrue(ValueHelper::isDateTime(new \DateTime()));
        self::assertTrue(ValueHelper::isDateTime('25/05/2017', 'd/m/Y'));
        self::assertFalse(ValueHelper::isDateTime('25/05/2017', 'm/d/Y'));
    }

    /**
     * Tests the isBool() method for boolean type validation.
     * 
     * Tests:
     * - Boolean values
     * - Non-boolean values
     */
    public function testIsBool()
    {
        self::assertTrue(ValueHelper::isBool(true));
        self::assertTrue(ValueHelper::isBool(false));
        self::assertFalse(ValueHelper::isBool(''));
        self::assertFalse(ValueHelper::isBool(null));
        self::assertFalse(ValueHelper::isBool([]));
        self::assertFalse(ValueHelper::isBool(new \stdClass()));
    }

    /**
     * Tests the isTrue() method for strict true value checking.
     * 
     * Tests:
     * - Boolean true
     * - Non-true values
     */
    public function testIsTrue()
    {
        self::assertTrue(ValueHelper::isTrue(true));
        self::assertFalse(ValueHelper::isTrue(false));
        self::assertFalse(ValueHelper::isTrue(1));
        self::assertFalse(ValueHelper::isTrue(''));
        self::assertFalse(ValueHelper::isTrue(null));
        self::assertFalse(ValueHelper::isTrue([]));
        self::assertFalse(ValueHelper::isTrue(new \stdClass()));
    }

    /**
     * Tests the isFalse() method for strict false value checking.
     * 
     * Tests:
     * - Boolean false
     * - Non-false values
     */
    public function testIsFalse()
    {
        self::assertTrue(ValueHelper::isFalse(false));
        self::assertFalse(ValueHelper::isFalse(true));
        self::assertFalse(ValueHelper::isTrue(0));
        self::assertFalse(ValueHelper::isFalse(''));
        self::assertFalse(ValueHelper::isFalse(null));
        self::assertFalse(ValueHelper::isFalse([]));
        self::assertFalse(ValueHelper::isFalse(new \stdClass()));
    }

    /**
     * Tests the isTrueLike() method for checking truthy values.
     * 
     * Tests:
     * - Boolean true
     * - Truthy values (1, '1', 'true', etc.)
     * - Non-truthy values
     */
    public function testIsTrueLike()
    {
        self::assertTrue(ValueHelper::isTrueLike(true));
        self::assertTrue(ValueHelper::isTrueLike(1));
        self::assertTrue(ValueHelper::isTrueLike(1.1));
        self::assertTrue(ValueHelper::isTrueLike('1'));
        self::assertTrue(ValueHelper::isTrueLike('abc'));
        self::assertTrue(ValueHelper::isTrueLike(new \stdClass()));
        self::assertFalse(ValueHelper::isTrueLike(false));
        self::assertFalse(ValueHelper::isTrueLike(''));
        self::assertFalse(ValueHelper::isTrueLike(null));
        self::assertFalse(ValueHelper::isTrueLike([]));
    }

    /**
     * Tests the isFalseLike() method for checking falsy values.
     * 
     * Tests:
     * - Boolean false
     * - Falsy values (0, '0', 'false', etc.)
     * - Non-falsy values
     */
    public function testIsFalseLike()
    {
        self::assertTrue(ValueHelper::isFalseLike(false));
        self::assertTrue(ValueHelper::isFalseLike(0));
        self::assertTrue(ValueHelper::isFalseLike(0.0));
        self::assertTrue(ValueHelper::isFalseLike('0'));
        self::assertTrue(ValueHelper::isFalseLike(null));
        self::assertTrue(ValueHelper::isFalseLike([]));
        self::assertFalse(ValueHelper::isFalseLike(1));
        self::assertFalse(ValueHelper::isFalseLike('abc'));
        self::assertFalse(ValueHelper::isFalseLike(new \stdClass()));
        self::assertFalse(ValueHelper::isFalseLike(true));
        self::assertFalse(ValueHelper::isFalseLike(' '));
    }
}
