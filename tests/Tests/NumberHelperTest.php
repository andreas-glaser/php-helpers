<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\NumberHelper;

/**
 * Class NumberHelperTest.
 */
class NumberHelperTest extends BaseTest
{
    public function testOrdinal()
    {
        self::assertEquals('st', NumberHelper::ordinal(1));
        self::assertEquals('nd', NumberHelper::ordinal(2));
        self::assertEquals('rd', NumberHelper::ordinal(3));
        self::assertEquals('th', NumberHelper::ordinal(4));
    }
}
