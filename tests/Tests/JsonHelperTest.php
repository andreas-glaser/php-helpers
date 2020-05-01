<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\JsonHelper;

/**
 * Class JsonHelperTest.
 */
class JsonHelperTest extends BaseTest
{
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
