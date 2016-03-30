<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\RandomHelper;

/**
 * Class RandomHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests
 * @author  Andreas Glaser
 */
class RandomHelperTest extends BaseTest
{
    /**
     * @author Andreas Glaser
     */
    public function testTrueFalse()
    {
        $this->assertInternalType('boolean', RandomHelper::trueFalse());
    }
}