<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\CounterHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * CounterHelperTest provides comprehensive unit tests for the CounterHelper class.
 *
 * This class tests counter functionality including:
 * - Factory method creation and initialization
 * - Incrementing and decrementing operations
 * - Value tracking and difference calculations
 * - Method chaining capabilities
 * - Edge cases and type handling
 */
class CounterHelperTest extends BaseTest
{
    /**
     * Tests the factory method with default initial value.
     * Verifies that a counter is created with default value of 0.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::f
     * @return void
     */
    public function testFactoryMethodWithDefaultValue()
    {
        $counter = CounterHelper::f();
        
        $this->assertInstanceOf(CounterHelper::class, $counter);
        $this->assertEquals(0, $counter->getInitialValue());
        $this->assertEquals(0, $counter->getCurrentValue());
    }

    /**
     * Tests the factory method with integer initial value.
     * Verifies that a counter is created with specified integer value.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::f
     * @return void
     */
    public function testFactoryMethodWithIntegerValue()
    {
        $counter = CounterHelper::f(10);
        
        $this->assertInstanceOf(CounterHelper::class, $counter);
        $this->assertEquals(10, $counter->getInitialValue());
        $this->assertEquals(10, $counter->getCurrentValue());
    }

    /**
     * Tests the factory method with array as initial value.
     * Verifies that a counter is created with array count as initial value.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::f
     * @return void
     */
    public function testFactoryMethodWithArrayValue()
    {
        $array = ['a', 'b', 'c', 'd', 'e'];
        $counter = CounterHelper::f($array);
        
        $this->assertInstanceOf(CounterHelper::class, $counter);
        $this->assertEquals(5, $counter->getInitialValue());
        $this->assertEquals(5, $counter->getCurrentValue());
    }

    /**
     * Tests constructor with default value.
     * Verifies direct instantiation works correctly.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::__construct
     * @return void
     */
    public function testConstructorWithDefaultValue()
    {
        $counter = new CounterHelper();
        
        $this->assertEquals(0, $counter->getInitialValue());
        $this->assertEquals(0, $counter->getCurrentValue());
    }

    /**
     * Tests constructor with positive integer value.
     * Verifies initialization with positive values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::__construct
     * @return void
     */
    public function testConstructorWithPositiveInteger()
    {
        $counter = new CounterHelper(25);
        
        $this->assertEquals(25, $counter->getInitialValue());
        $this->assertEquals(25, $counter->getCurrentValue());
    }

    /**
     * Tests constructor with negative integer value.
     * Verifies initialization with negative values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::__construct
     * @return void
     */
    public function testConstructorWithNegativeInteger()
    {
        $counter = new CounterHelper(-10);
        
        $this->assertEquals(-10, $counter->getInitialValue());
        $this->assertEquals(-10, $counter->getCurrentValue());
    }

    /**
     * Tests constructor with empty array.
     * Verifies that empty array results in zero count.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::__construct
     * @return void
     */
    public function testConstructorWithEmptyArray()
    {
        $counter = new CounterHelper([]);
        
        $this->assertEquals(0, $counter->getInitialValue());
        $this->assertEquals(0, $counter->getCurrentValue());
    }

    /**
     * Tests increaseBy method with positive value.
     * Verifies that counter increases correctly and supports method chaining.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::increaseBy
     * @return void
     */
    public function testIncreaseByPositiveValue()
    {
        $counter = CounterHelper::f(10);
        $result = $counter->increaseBy(5);
        
        // Check method chaining
        $this->assertSame($counter, $result);
        $this->assertEquals(10, $counter->getInitialValue());
        $this->assertEquals(15, $counter->getCurrentValue());
    }

    /**
     * Tests increaseBy method with negative value.
     * Verifies that increasing by negative value decreases the counter.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::increaseBy
     * @return void
     */
    public function testIncreaseByNegativeValue()
    {
        $counter = CounterHelper::f(10);
        $counter->increaseBy(-3);
        
        $this->assertEquals(10, $counter->getInitialValue());
        $this->assertEquals(7, $counter->getCurrentValue());
    }

    /**
     * Tests decreaseBy method with positive value.
     * Verifies that counter decreases correctly and supports method chaining.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::decreaseBy
     * @return void
     */
    public function testDecreaseByPositiveValue()
    {
        $counter = CounterHelper::f(10);
        $result = $counter->decreaseBy(3);
        
        // Check method chaining
        $this->assertSame($counter, $result);
        $this->assertEquals(10, $counter->getInitialValue());
        $this->assertEquals(7, $counter->getCurrentValue());
    }

    /**
     * Tests decreaseBy method with negative value.
     * Verifies that decreasing by negative value increases the counter.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::decreaseBy
     * @return void
     */
    public function testDecreaseByNegativeValue()
    {
        $counter = CounterHelper::f(10);
        $counter->decreaseBy(-5);
        
        $this->assertEquals(10, $counter->getInitialValue());
        $this->assertEquals(15, $counter->getCurrentValue());
    }

    /**
     * Tests plusOne method functionality.
     * Verifies that counter increments by one and supports method chaining.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::plusOne
     * @return void
     */
    public function testPlusOne()
    {
        $counter = CounterHelper::f(5);
        $result = $counter->plusOne();
        
        // Check method chaining
        $this->assertSame($counter, $result);
        $this->assertEquals(5, $counter->getInitialValue());
        $this->assertEquals(6, $counter->getCurrentValue());
    }

    /**
     * Tests minusOne method functionality.
     * Verifies that counter decrements by one and supports method chaining.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::minusOne
     * @return void
     */
    public function testMinusOne()
    {
        $counter = CounterHelper::f(5);
        $result = $counter->minusOne();
        
        // Check method chaining
        $this->assertSame($counter, $result);
        $this->assertEquals(5, $counter->getInitialValue());
        $this->assertEquals(4, $counter->getCurrentValue());
    }

    /**
     * Tests getDifference method when values are equal.
     * Verifies that difference is zero when current equals initial value.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::getDifference
     * @return void
     */
    public function testGetDifferenceWhenEqual()
    {
        $counter = CounterHelper::f(10);
        
        $this->assertEquals(0, $counter->getDifference());
    }

    /**
     * Tests getDifference method when current value is higher.
     * Verifies that absolute difference is calculated correctly.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::getDifference
     * @return void
     */
    public function testGetDifferenceWhenCurrentValueHigher()
    {
        $counter = CounterHelper::f(10);
        $counter->increaseBy(5);
        
        $this->assertEquals(5, $counter->getDifference());
    }

    /**
     * Tests getDifference method when current value is lower.
     * Verifies that absolute difference is calculated correctly.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::getDifference
     * @return void
     */
    public function testGetDifferenceWhenCurrentValueLower()
    {
        $counter = CounterHelper::f(10);
        $counter->decreaseBy(3);
        
        $this->assertEquals(3, $counter->getDifference());
    }

    /**
     * Tests method chaining capabilities.
     * Verifies that multiple operations can be chained together.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::plusOne
     * @covers \AndreasGlaser\Helpers\CounterHelper::minusOne
     * @covers \AndreasGlaser\Helpers\CounterHelper::increaseBy
     * @covers \AndreasGlaser\Helpers\CounterHelper::decreaseBy
     * @return void
     */
    public function testMethodChaining()
    {
        $counter = CounterHelper::f(0);
        
        $result = $counter
            ->plusOne()           // 1
            ->plusOne()           // 2
            ->increaseBy(3)       // 5
            ->minusOne()          // 4
            ->decreaseBy(2);      // 2
        
        $this->assertSame($counter, $result);
        $this->assertEquals(0, $counter->getInitialValue());
        $this->assertEquals(2, $counter->getCurrentValue());
        $this->assertEquals(2, $counter->getDifference());
    }

    /**
     * Tests __toString method functionality.
     * Verifies that counter can be converted to string representation.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::__toString
     * @return void
     */
    public function testToString()
    {
        $counter = CounterHelper::f(42);
        
        $this->assertEquals('42', (string)$counter);
        $this->assertEquals('42', $counter->__toString());
    }

    /**
     * Tests __toString method after modifications.
     * Verifies that string representation reflects current value.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::__toString
     * @return void
     */
    public function testToStringAfterModifications()
    {
        $counter = CounterHelper::f(10);
        $counter->plusOne()->increaseBy(4);
        
        $this->assertEquals('15', (string)$counter);
    }

    /**
     * Tests edge case with zero operations.
     * Verifies that increasing and decreasing by zero has no effect.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::increaseBy
     * @covers \AndreasGlaser\Helpers\CounterHelper::decreaseBy
     * @return void
     */
    public function testZeroOperations()
    {
        $counter = CounterHelper::f(10);
        
        $counter->increaseBy(0)->decreaseBy(0);
        
        $this->assertEquals(10, $counter->getCurrentValue());
        $this->assertEquals(0, $counter->getDifference());
    }

    /**
     * Tests edge case with large values.
     * Verifies that counter handles large integer values correctly.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::increaseBy
     * @covers \AndreasGlaser\Helpers\CounterHelper::decreaseBy
     * @return void
     */
    public function testLargeValues()
    {
        $counter = CounterHelper::f(1000000);
        
        $counter->increaseBy(500000);
        
        $this->assertEquals(1000000, $counter->getInitialValue());
        $this->assertEquals(1500000, $counter->getCurrentValue());
        $this->assertEquals(500000, $counter->getDifference());
    }

    /**
     * Tests type coercion with string values.
     * Verifies that string numeric values are properly converted to integers.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::increaseBy
     * @covers \AndreasGlaser\Helpers\CounterHelper::decreaseBy
     * @return void
     */
    public function testStringValueCoercion()
    {
        $counter = CounterHelper::f(10);
        
        $counter->increaseBy('5')->decreaseBy('2');
        
        $this->assertEquals(13, $counter->getCurrentValue());
    }

    /**
     * Tests comprehensive workflow scenario.
     * Verifies a complex real-world usage pattern.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::f
     * @covers \AndreasGlaser\Helpers\CounterHelper::plusOne
     * @covers \AndreasGlaser\Helpers\CounterHelper::minusOne
     * @covers \AndreasGlaser\Helpers\CounterHelper::increaseBy
     * @covers \AndreasGlaser\Helpers\CounterHelper::getDifference
     * @return void
     */
    public function testComprehensiveWorkflow()
    {
        // Simulate counting items in an inventory
        $itemsArray = ['item1', 'item2', 'item3'];
        $inventory = CounterHelper::f($itemsArray); // Start with 3 items
        
        // Add some items
        $inventory->increaseBy(7); // Add 7 more items (total: 10)
        
        // Remove a few items
        $inventory->minusOne()->minusOne(); // Remove 2 items (total: 8)
        
        // Add one more batch
        $inventory->increaseBy(5); // Add 5 more (total: 13)
        
        // Final checks
        $this->assertEquals(3, $inventory->getInitialValue());
        $this->assertEquals(13, $inventory->getCurrentValue());
        $this->assertEquals(10, $inventory->getDifference());
        $this->assertEquals('13', (string)$inventory);
    }

    /**
     * Tests negative initial value with operations.
     * Verifies that counter works correctly with negative starting values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CounterHelper::__construct
     * @covers \AndreasGlaser\Helpers\CounterHelper::plusOne
     * @covers \AndreasGlaser\Helpers\CounterHelper::minusOne
     * @return void
     */
    public function testNegativeInitialValueOperations()
    {
        $counter = CounterHelper::f(-5);
        
        $counter->plusOne()->plusOne()->plusOne(); // -5 + 3 = -2
        
        $this->assertEquals(-5, $counter->getInitialValue());
        $this->assertEquals(-2, $counter->getCurrentValue());
        $this->assertEquals(3, $counter->getDifference());
    }
} 