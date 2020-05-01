<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\RandomHelper;

/**
 * Class RandomHelperTest.
 */
class RandomHelperTest extends BaseTest
{
    public function testTrueFalse()
    {
        self::assertEquals('boolean', \gettype(RandomHelper::trueFalse()));
    }

    public function testUniqid()
    {
        self::assertEquals(13, \strlen(RandomHelper::uniqid()));

        self::assertStringStartsWith('my_prefix_', RandomHelper::uniqid('my_prefix_'));
        self::assertEquals(23, \strlen(RandomHelper::uniqid('my_prefix_')));

        $uniqueIds = [];

        for ($i = 1; $i <= 1000000; ++$i) {
            $uniqueIds[] = RandomHelper::uniqid();
        }

        self::assertEquals(\count($uniqueIds), \count(\array_unique($uniqueIds)));
    }
}
