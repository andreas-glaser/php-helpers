<?php

namespace AndreasGlaser\Helpers\Tests\Random;

use AndreasGlaser\Helpers\RandomHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * RandomHelperTest provides unit tests for the RandomHelper class.
 *
 * This class tests random value generation:
 * - Generating random boolean values
 * - Generating unique identifiers
 */
class RandomHelperTest extends BaseTest
{
    /**
     * Tests the trueFalse() method for generating random boolean values.
     * Verifies that the method returns a boolean value.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::trueFalse
     * @return void
     */
    public function testTrueFalse()
    {
        self::assertEquals('boolean', \gettype(RandomHelper::trueFalse()));
    }

    /**
     * Tests the uniqid() method for generating unique identifiers.
     * Verifies length of generated IDs, prefix handling, and uniqueness of generated values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\RandomHelper::uniqid
     * @return void
     */
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
