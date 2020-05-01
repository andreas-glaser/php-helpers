<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\DateHelper;

/**
 * Class DateHelperTest.
 */
class DateHelperTest extends BaseTest
{
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

    public function testFormatOrNull()
    {
        self::assertEquals('23-03-2015', DateHelper::formatOrNull('2015-03-23', 'd-m-Y'));
        self::assertEquals('23-03-2015', DateHelper::formatOrNull(new \DateTime('2015-03-23'), 'd-m-Y'));
        self::assertEquals(\date('Y-m-d H:i:s'), DateHelper::formatOrNull('NOW'));
        self::assertEquals(10, DateHelper::formatOrNull(new \stdClass(), 'Y-m-d', 10));
        self::assertNull(DateHelper::formatOrNull(-1));
    }

    public function testDiffHours()
    {
        self::assertEquals(0, DateHelper::diffHours(new \DateTime('2017-01-01 12:00:00'), new \DateTime('2017-01-01 12:30:00')));
        self::assertEquals(1, DateHelper::diffHours(new \DateTime('2017-01-01 12:00:00'), new \DateTime('2017-01-01 13:00:00')));
        self::assertEquals(24, DateHelper::diffHours(new \DateTime('2017-01-01 12:00:00'), new \DateTime('2017-01-02 12:00:00')));
    }

    public function testDiffDays()
    {
        self::assertEquals(1, DateHelper::diffDays(new \DateTime('2017-01-01'), new \DateTime('2017-01-02')));
        self::assertEquals(31, DateHelper::diffDays(new \DateTime('2017-01-01'), new \DateTime('2017-02-01')));
        self::assertEquals(28, DateHelper::diffDays(new \DateTime('2017-02-01'), new \DateTime('2017-03-01')));
        self::assertEquals(29, DateHelper::diffDays(new \DateTime('2016-02-01'), new \DateTime('2016-03-01'))); // leap year
        self::assertEquals(366, DateHelper::diffDays(new \DateTime('2016-01-01'), new \DateTime('2017-01-01'))); // leap year
    }

    public function testDiffMonths()
    {
        self::assertEquals(0, DateHelper::diffMonths(new \DateTime('2017-01-01'), new \DateTime('2017-01-22')));
        self::assertEquals(1, DateHelper::diffMonths(new \DateTime('2017-01-01'), new \DateTime('2017-02-01')));
        self::assertEquals(1, DateHelper::diffMonths(new \DateTime('2017-01-01'), new \DateTime('2017-02-15')));
        self::assertEquals(12, DateHelper::diffMonths(new \DateTime('2017-01-01'), new \DateTime('2018-01-01')));
    }

    public function testDiffYears()
    {
        self::assertEquals(0, DateHelper::diffYears(new \DateTime('2017-01-01'), new \DateTime('2017-12-31')));
        self::assertEquals(1, DateHelper::diffYears(new \DateTime('2017-01-01'), new \DateTime('2018-01-01')));
        self::assertEquals(2, DateHelper::diffYears(new \DateTime('2017-01-01'), new \DateTime('2019-05-01')));
    }
}
