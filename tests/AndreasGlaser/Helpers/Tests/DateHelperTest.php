<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\DateHelper;

/**
 * Class DateHelperTest
 *
 * @package Helpers\Tests
 *
 * @author  Andreas Glaser
 */
class DateHelperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @author Andreas Glaser
     */
    public function testIs()
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
}