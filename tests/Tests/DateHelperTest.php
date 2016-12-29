<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\DateHelper;

/**
 * Class DateHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests
 * @author  Andreas Glaser
 */
class DateHelperTest extends BaseTest
{

    /**
     * @author Andreas Glaser
     */
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
    }

    /**
     * @author Andreas Glaser
     */
    public function testFormatOrNull()
    {
        $this->assertEquals('23-03-2015', DateHelper::formatOrNull('2015-03-23', 'd-m-Y'));
        $this->assertEquals('23-03-2015', DateHelper::formatOrNull(new \DateTime('2015-03-23'), 'd-m-Y'));
        $this->assertEquals(date('Y-m-d H:i:s'), DateHelper::formatOrNull('NOW'));
        $this->assertEquals(10, DateHelper::formatOrNull(new \stdClass(), 'Y-m-d', 10));
        $this->assertNull(DateHelper::formatOrNull(-1));
    }
}