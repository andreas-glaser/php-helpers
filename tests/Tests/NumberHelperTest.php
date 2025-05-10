<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\NumberHelper;

/**
 * NumberHelperTest provides unit tests for the NumberHelper class.
 *
 * This class tests number formatting and manipulation:
 * - Converting numbers to ordinal suffixes
 */
class NumberHelperTest extends BaseTest
{
    /**
     * Tests the ordinal() method for converting numbers to ordinal suffixes.
     */
    public function testOrdinal()
    {
        self::assertEquals('st', NumberHelper::ordinal(1));
        self::assertEquals('nd', NumberHelper::ordinal(2));
        self::assertEquals('rd', NumberHelper::ordinal(3));
        self::assertEquals('th', NumberHelper::ordinal(4));
    }
}
