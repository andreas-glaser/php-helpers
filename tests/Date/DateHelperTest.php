<?php

namespace AndreasGlaser\Helpers\Tests\Date;

use AndreasGlaser\Helpers\DateHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * DateHelperTest provides unit tests for the DateHelper class.
 *
 * This class tests date manipulation and formatting:
 * - Converting strings to DateTime objects
 * - Formatting dates with fallback values
 * - Calculating time differences (hours, days, months, years)
 */
class DateHelperTest extends BaseTest
{
    /**
     * Tests converting various string formats to DateTime objects.
     * Verifies handling of valid dates, invalid dates, and custom fallback values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\DateHelper::stringToDateTime
     * @return void
     */
    public function testStringToDateTime()
    {
        self::assertTrue(DateHelper::stringToDateTime('2015-03-23') instanceof \DateTime);
        self::assertTrue(DateHelper::stringToDateTime('2015-03-23 22:21') instanceof \DateTime);
        self::assertTrue(DateHelper::stringToDateTime('5pm') instanceof \DateTime);
        self::assertTrue(DateHelper::stringToDateTime('+8 Weeks') instanceof \DateTime);

        self::assertNull(DateHelper::stringToDateTime('2015-13-23 22:21'));
        self::assertNull(DateHelper::stringToDateTime('2015-12-23 25:21'));
        self::assertNull(DateHelper::stringToDateTime('2015-12-23 25:21:71'));
        self::assertNull(DateHelper::stringToDateTime('N/A'));
        self::assertNull(DateHelper::stringToDateTime(null));
        self::assertNull(DateHelper::stringToDateTime(''));

        self::assertEquals('DEFAULT', DateHelper::stringToDateTime('', null, 'DEFAULT'));
    }

    /**
     * Tests formatting dates with fallback values.
     * Verifies formatting of DateTime objects, strings, and handling of invalid inputs.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\DateHelper::formatOrNull
     * @return void
     */
    public function testFormatOrNull()
    {
        self::assertEquals('23-03-2015', DateHelper::formatOrNull('2015-03-23', 'd-m-Y'));
        self::assertEquals('23-03-2015', DateHelper::formatOrNull(new \DateTime('2015-03-23'), 'd-m-Y'));
        self::assertEquals(\date('Y-m-d H:i:s'), DateHelper::formatOrNull('NOW'));
        self::assertEquals(10, DateHelper::formatOrNull(new \stdClass(), 'Y-m-d', 10));
        self::assertNull(DateHelper::formatOrNull(-1));
    }

    /**
     * Tests calculating hour differences between dates.
     * Verifies calculation of hour differences including partial hours and multiple days.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\DateHelper::diffHours
     * @return void
     */
    public function testDiffHours()
    {
        self::assertEquals(0, DateHelper::diffHours(new \DateTime('2017-01-01 12:00:00'), new \DateTime('2017-01-01 12:30:00')));
        self::assertEquals(1, DateHelper::diffHours(new \DateTime('2017-01-01 12:00:00'), new \DateTime('2017-01-01 13:00:00')));
        self::assertEquals(24, DateHelper::diffHours(new \DateTime('2017-01-01 12:00:00'), new \DateTime('2017-01-02 12:00:00')));
    }

    /**
     * Tests calculating day differences between dates.
     * Verifies calculation of day differences including month boundaries and leap years.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\DateHelper::diffDays
     * @return void
     */
    public function testDiffDays()
    {
        self::assertEquals(1, DateHelper::diffDays(new \DateTime('2017-01-01'), new \DateTime('2017-01-02')));
        self::assertEquals(31, DateHelper::diffDays(new \DateTime('2017-01-01'), new \DateTime('2017-02-01')));
        self::assertEquals(28, DateHelper::diffDays(new \DateTime('2017-02-01'), new \DateTime('2017-03-01')));
        self::assertEquals(29, DateHelper::diffDays(new \DateTime('2016-02-01'), new \DateTime('2016-03-01'))); // leap year
        self::assertEquals(366, DateHelper::diffDays(new \DateTime('2016-01-01'), new \DateTime('2017-01-01'))); // leap year
    }

    /**
     * Tests calculating month differences between dates.
     * Verifies calculation of month differences including partial months and year boundaries.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\DateHelper::diffMonths
     * @return void
     */
    public function testDiffMonths()
    {
        self::assertEquals(0, DateHelper::diffMonths(new \DateTime('2017-01-01'), new \DateTime('2017-01-22')));
        self::assertEquals(1, DateHelper::diffMonths(new \DateTime('2017-01-01'), new \DateTime('2017-02-01')));
        self::assertEquals(1, DateHelper::diffMonths(new \DateTime('2017-01-01'), new \DateTime('2017-02-15')));
        self::assertEquals(12, DateHelper::diffMonths(new \DateTime('2017-01-01'), new \DateTime('2018-01-01')));
    }

    /**
     * Tests calculating year differences between dates.
     * Verifies calculation of year differences including partial years.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\DateHelper::diffYears
     * @return void
     */
    public function testDiffYears()
    {
        self::assertEquals(0, DateHelper::diffYears(new \DateTime('2017-01-01'), new \DateTime('2017-12-31')));
        self::assertEquals(1, DateHelper::diffYears(new \DateTime('2017-01-01'), new \DateTime('2018-01-01')));
        self::assertEquals(2, DateHelper::diffYears(new \DateTime('2017-01-01'), new \DateTime('2019-05-01')));
    }
}
