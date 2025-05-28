<?php

namespace AndreasGlaser\Helpers\Tests\Json;

use AndreasGlaser\Helpers\JsonHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * JsonHelperTest provides unit tests for the JsonHelper class.
 *
 * This class tests JSON validation:
 * - Validating various data types
 * - Validating JSON strings
 * - Validating complex JSON structures
 */
class JsonHelperTest extends BaseTest
{
    /**
     * Tests the isValid() method with various input types and JSON strings.
     * Verifies validation of:
     * - Primitive types (numbers, booleans, null)
     * - String representations of JSON values
     * - Arrays and objects
     * - Nested structures
     *
     * @test
     * @covers \AndreasGlaser\Helpers\JsonHelper::isValid
     * @return void
     */
    public function testIsValid()
    {
        self::assertTrue(JsonHelper::isValid(123));
        self::assertTrue(JsonHelper::isValid(123.43));
        self::assertTrue(JsonHelper::isValid(true));
        self::assertFalse(JsonHelper::isValid(false));
        self::assertFalse(JsonHelper::isValid(null));
        self::assertTrue(JsonHelper::isValid('true'));
        self::assertTrue(JsonHelper::isValid('false'));
        self::assertTrue(JsonHelper::isValid('null'));
        self::assertTrue(JsonHelper::isValid('"abc"'));
        self::assertFalse(JsonHelper::isValid("'abc'"));
        self::assertFalse(JsonHelper::isValid('00 11 22'));
        self::assertTrue(JsonHelper::isValid('[1,2,3, null, true, false, "abc"]'));
        self::assertTrue(JsonHelper::isValid('{"a":{},"b":false}'));
        self::assertTrue(JsonHelper::isValid('[1,2,3,4]'));
        self::assertTrue(JsonHelper::isValid('{"b":{},"c":[{},[1,2,3,true,false,null]]}'));
    }
}
