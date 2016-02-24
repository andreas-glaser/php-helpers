<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\RandomHelper;

/**
 * Class RandomHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests
 * @author  Andreas Glaser
 */
class RandomHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @author Andreas Glaser
     */
    public function testTrueFalse()
    {
        $this->assertInternalType('boolean', RandomHelper::trueFalse());
    }
}