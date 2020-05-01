<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\CounterHelper;

/**
 * Class CounterHelperTest.
 */
class CounterHelperTest extends BaseTest
{
    public function test()
    {
        self::assertInstanceOf('\\AndreasGlaser\\Helpers\\CounterHelper', CounterHelper::f());
        self::assertEquals(13, CounterHelper::f(13)->getInitialValue());
        self::assertEquals(1, CounterHelper::f()->plusOne()->getCurrentValue());
        self::assertEquals(-1, CounterHelper::f()->minusOne()->getCurrentValue());
        self::assertEquals(2, CounterHelper::f(['a', 'b'])->getInitialValue());
        self::assertEquals(0, CounterHelper::f(32)->getDifference());
        self::assertEquals(1, CounterHelper::f(1000)->minusOne()->getDifference());
        self::assertEquals(1, CounterHelper::f(1000)->minusOne()->increaseBy(2)->getDifference());
        self::assertEquals('-125', (string)CounterHelper::f()->decreaseBy(125)->getCurrentValue());
    }
}
