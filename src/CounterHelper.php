<?php

namespace AndreasGlaser\Helpers;

use AndreasGlaser\Helpers\Interfaces\FactoryInterface;

/**
 * CounterHelper provides utility methods for counting and tracking numeric values.
 * 
 * This class implements a counter that can be incremented, decremented,
 * and compared against its initial value. Useful for tracking progress,
 * counting items, or measuring changes in values.
 */
class CounterHelper implements FactoryInterface
{
    /**
     * @var int The starting value of the counter
     */
    protected $initialValue = 0;

    /**
     * @var int The current value of the counter
     */
    protected $currentValue = 0;

    /**
     * Factory method to create a new CounterHelper instance.
     *
     * @param int|array $initialValue The initial value or array to count
     *
     * @return \AndreasGlaser\Helpers\CounterHelper A new counter instance
     */
    public static function f($initialValue = 0)
    {
        return new CounterHelper($initialValue);
    }

    /**
     * Creates a new counter with the specified initial value.
     *
     * @param int|array $initialValue The initial value or array to count
     */
    public function __construct($initialValue = 0)
    {
        $this->initialValue = \is_array($initialValue) ? \count($initialValue) : (int)$initialValue;
        $this->currentValue = $this->initialValue;
    }

    /**
     * Increases the counter by the specified value.
     *
     * @param int $value The amount to increase by
     *
     * @return $this For method chaining
     */
    public function increaseBy($value):self
    {
        $this->currentValue += (int)$value;

        return $this;
    }

    /**
     * Decreases the counter by the specified value.
     *
     * @param int $value The amount to decrease by
     *
     * @return $this For method chaining
     */
    public function decreaseBy($value):self
    {
        $this->currentValue -= (int)$value;

        return $this;
    }

    /**
     * Increases the counter by one.
     *
     * @return \AndreasGlaser\Helpers\CounterHelper For method chaining
     */
    public function plusOne()
    {
        return $this->increaseBy(1);
    }

    /**
     * Decreases the counter by one.
     *
     * @return \AndreasGlaser\Helpers\CounterHelper For method chaining
     */
    public function minusOne()
    {
        return $this->decreaseBy(1);
    }

    /**
     * Gets the initial value of the counter.
     *
     * @return int The initial value
     */
    public function getInitialValue()
    {
        return $this->initialValue;
    }

    /**
     * Gets the current value of the counter.
     *
     * @return int The current value
     */
    public function getCurrentValue()
    {
        return $this->currentValue;
    }

    /**
     * Gets the absolute difference between the current and initial values.
     *
     * @return int The absolute difference
     */
    public function getDifference()
    {
        if ($this->initialValue === $this->currentValue) {
            return 0;
        }

        return \abs($this->currentValue - $this->initialValue);
    }

    /**
     * Returns the current value as a string.
     *
     * @return string The current value as a string
     */
    public function __toString()
    {
        return (string)$this->getCurrentValue();
    }
}
