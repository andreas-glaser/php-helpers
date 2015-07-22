<?php

namespace AndreasGlaser\Helpers\Test;

use AndreasGlaser\Helpers\NumberHelper;

/**
 * Class NumberHelperTest
 *
 * @package AndreasGlaser\Helpers\Test
 * @author  Andreas Glaser
 */
class NumberHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testOrdinal()
    {
        $this->assertEquals('st', NumberHelper::ordinal(1));
        $this->assertEquals('nd', NumberHelper::ordinal(2));
        $this->assertEquals('rd', NumberHelper::ordinal(3));
        $this->assertEquals('th', NumberHelper::ordinal(4));
    }
}