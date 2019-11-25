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

    public function testTrueFalse()
    {
        $this->assertInternalType('boolean', RandomHelper::trueFalse());
    }

    public function testUniqid()
    {
        $this->assertEquals(13, strlen(RandomHelper::uniqid()));

        $this->assertStringStartsWith('my_prefix_', RandomHelper::uniqid('my_prefix_'));
        $this->assertEquals(23, strlen(RandomHelper::uniqid('my_prefix_')));

        $uniqueIds = [];

        for ($i = 1; $i <= 1000000; $i++) {
            $uniqueIds[] = RandomHelper::uniqid();
        }

        $this->assertEquals(count($uniqueIds), count(array_unique($uniqueIds)));
    }
}