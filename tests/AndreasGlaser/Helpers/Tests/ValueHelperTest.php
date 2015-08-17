<?php

namespace AndreasGlaser\Helpers\Test;

use AndreasGlaser\Helpers\ValueHelper;

/**
 * Class ValueHelperTest
 *
 * @package AndreasGlaser\Helpers\Test
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
}