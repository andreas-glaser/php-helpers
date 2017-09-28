<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\DateHelper;

/**
 * Class DateHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests
 */
class DateHelperTest extends BaseTest
{

    public function testStringToDateTime()
    {
        $this->assertTrue(DateHelper::stringToDateTime('2015-03-23') instanceof \DateTime);
        $this->assertTrue(DateHelper::stringToDateTime('2015-03-23 22:21') instanceof \DateTime);
        $this->assertTrue(DateHelper::stringToDateTime('5pm') instanceof \DateTime);
        $this->assertTrue(DateHelper::stringToDateTime('+8 Weeks') instanceof \DateTime);

        $this->assertNull(DateHelper::stringToDateTime('2015-13-23 22:21'));
        $this->assertNull(DateHelper::stringToDateTime('2015-12-23 25:21'));
        $this->assertNull(DateHelper::stringToDateTime('2015-12-23 25:21:71'));
        $this->assertNull(DateHelper::stringToDateTime('N/A'));
        $this->assertNull(DateHelper::stringToDateTime(null));
        $this->assertNull(DateHelper::stringToDateTime(''));

        $this->assertEquals('DEFAULT', DateHelper::stringToDateTime('', null, 'DEFAULT'));
    }

    public function testFormatOrNull()
    {
        $this->assertEquals('23-03-2015', DateHelper::formatOrNull('2015-03-23', 'd-m-Y'));
        $this->assertEquals('23-03-2015', DateHelper::formatOrNull(new \DateTime('2015-03-23'), 'd-m-Y'));
        $this->assertEquals(date('Y-m-d H:i:s'), DateHelper::formatOrNull('NOW'));
        $this->assertEquals(10, DateHelper::formatOrNull(new \stdClass(), 'Y-m-d', 10));
        $this->assertNull(DateHelper::formatOrNull(-1));
    }

    public function testDiffHours()
    {
        $this->assertEquals(0, DateHelper::diffHours(new \DateTime('2017-01-01 12:00:00'), new \DateTime('2017-01-01 12:30:00')));
        $this->assertEquals(1, DateHelper::diffHours(new \DateTime('2017-01-01 12:00:00'), new \DateTime('2017-01-01 13:00:00')));
        $this->assertEquals(24, DateHelper::diffHours(new \DateTime('2017-01-01 12:00:00'), new \DateTime('2017-01-02 12:00:00')));
    }

    public function testDiffDays()
    {
        $this->assertEquals(1, DateHelper::diffDays(new \DateTime('2017-01-01'), new \DateTime('2017-01-02')));
        $this->assertEquals(31, DateHelper::diffDays(new \DateTime('2017-01-01'), new \DateTime('2017-02-01')));
        $this->assertEquals(28, DateHelper::diffDays(new \DateTime('2017-02-01'), new \DateTime('2017-03-01')));
        $this->assertEquals(29, DateHelper::diffDays(new \DateTime('2016-02-01'), new \DateTime('2016-03-01'))); // leap year
        $this->assertEquals(366, DateHelper::diffDays(new \DateTime('2016-01-01'), new \DateTime('2017-01-01'))); // leap year
    }

    public function testDiffMonths()
    {
        $this->assertEquals(0, DateHelper::diffMonths(new \DateTime('2017-01-01'), new \DateTime('2017-01-22')));
        $this->assertEquals(1, DateHelper::diffMonths(new \DateTime('2017-01-01'), new \DateTime('2017-02-01')));
        $this->assertEquals(1, DateHelper::diffMonths(new \DateTime('2017-01-01'), new \DateTime('2017-02-15')));
        $this->assertEquals(12, DateHelper::diffMonths(new \DateTime('2017-01-01'), new \DateTime('2018-01-01')));
    }

    public function testDiffYears()
    {
        $this->assertEquals(0, DateHelper::diffYears(new \DateTime('2017-01-01'), new \DateTime('2017-12-31')));
        $this->assertEquals(1, DateHelper::diffYears(new \DateTime('2017-01-01'), new \DateTime('2018-01-01')));
        $this->assertEquals(2, DateHelper::diffYears(new \DateTime('2017-01-01'), new \DateTime('2019-05-01')));
    }
}