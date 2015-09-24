<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\ValueHelper;

/**
 * Class ValueHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests
 * @author  Andreas Glaser
 */
class ValueHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @author Andreas Glaser
     */
    public function testEmptyToNull()
    {
        $nullValues = [
            '',
            0,
            0.0,
            '0',
            null,
            false,
            []
        ];

        foreach ($nullValues AS $value) {
            $this->assertNull(ValueHelper::emptyToNull($value));
        }

        $noneNullValues = [
            '1',
            1,
            0.2,
            true,
            ['abc']
        ];

        foreach ($noneNullValues AS $value) {
            $this->assertNotNull(ValueHelper::emptyToNull($value));
        }
    }

    /**
     * @author Andreas Glaser
     */
    public function testIsEmpty()
    {
        $this->assertTrue(ValueHelper::isEmpty(''));
        $this->assertTrue(ValueHelper::isEmpty('0'));
        $this->assertTrue(ValueHelper::isEmpty(0));
        $this->assertTrue(ValueHelper::isEmpty(0.0));
        $this->assertTrue(ValueHelper::isEmpty(null));
        $this->assertTrue(ValueHelper::isEmpty(false));
        $this->assertTrue(ValueHelper::isEmpty([]));

        $this->assertFalse(ValueHelper::isEmpty(' '));
        $this->assertFalse(ValueHelper::isEmpty('1'));
        $this->assertFalse(ValueHelper::isEmpty(1));
        $this->assertFalse(ValueHelper::isEmpty(0.1));
        $this->assertFalse(ValueHelper::isEmpty(true));
        $this->assertFalse(ValueHelper::isEmpty([0]));
    }
}