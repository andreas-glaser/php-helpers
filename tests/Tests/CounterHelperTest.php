<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\CounterHelper;

/**
 * Class CounterHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests
 * @author  Andreas Glaser
 */
class CounterHelperTest extends BaseTest
{
    /**
     * @author Andreas Glaser
     */
    public function test()
    {
        $this->assertInstanceOf('\\AndreasGlaser\\Helpers\\CounterHelper', CounterHelper::f());
        $this->assertEquals(13, CounterHelper::f(13)->getInitialValue());
        $this->assertEquals(1, CounterHelper::f()->plusOne()->getCurrentValue());
        $this->assertEquals(-1, CounterHelper::f()->minusOne()->getCurrentValue());
        $this->assertEquals(2, CounterHelper::f(['a', 'b'])->getInitialValue());
        $this->assertEquals(0, CounterHelper::f(32)->getDifference());
        $this->assertEquals(1, CounterHelper::f(1000)->minusOne()->getDifference());
        $this->assertEquals(1, CounterHelper::f(1000)->minusOne()->increaseBy(2)->getDifference());
        $this->assertEquals('-125', (string)CounterHelper::f()->decreaseBy(125)->getCurrentValue());
    }
}