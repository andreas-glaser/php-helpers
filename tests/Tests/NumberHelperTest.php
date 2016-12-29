<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\NumberHelper;

/**
 * Class NumberHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests
 * @author  Andreas Glaser
 */
class NumberHelperTest extends BaseTest
{
    public function testOrdinal()
    {
        $this->assertEquals('st', NumberHelper::ordinal(1));
        $this->assertEquals('nd', NumberHelper::ordinal(2));
        $this->assertEquals('rd', NumberHelper::ordinal(3));
        $this->assertEquals('th', NumberHelper::ordinal(4));
    }
}