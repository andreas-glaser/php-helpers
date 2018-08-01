<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\RandomHelper;

/**
 * Class RandomHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests
 */
class RandomHelperTest extends BaseTest
{
    /**
     */
    public function testTrueFalse()
    {
        $this->assertInternalType('boolean', RandomHelper::trueFalse());
    }
}