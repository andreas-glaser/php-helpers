<?php

namespace AndreasGlaser\Helpers\Tests\Number;

use AndreasGlaser\Helpers\NumberHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

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
     * Verifies correct ordinal suffix generation for different numbers (1st, 2nd, 3rd, 4th, etc.).
     *
     * @test
     * @covers \AndreasGlaser\Helpers\NumberHelper::ordinal
     * @return void
     */
    public function testOrdinal()
    {
        self::assertEquals('st', NumberHelper::ordinal(1));
        self::assertEquals('nd', NumberHelper::ordinal(2));
        self::assertEquals('rd', NumberHelper::ordinal(3));
        self::assertEquals('th', NumberHelper::ordinal(4));
    }
}
