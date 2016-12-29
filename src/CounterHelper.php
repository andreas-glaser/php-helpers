<?php

namespace AndreasGlaser\Helpers;

use AndreasGlaser\Helpers\Interfaces\FactoryInterface;

/**
 * Class CounterHelper
 *
 * @package AndreasGlaser\Helpers
 * @author  Andreas Glaser
 */
class CounterHelper implements FactoryInterface
{
    /**
     * @var int
     */
    protected $initialValue = 0;

    /**
     * @var int
     */
    protected $currentValue = 0;

    /**
     * @param int|array $initialValue
     *
     * @return \AndreasGlaser\Helpers\CounterHelper
     * @author Andreas Glaser
     */
    public static function f($initialValue = 0)
    {
        return new CounterHelper($initialValue);
    }

    /**
     * @param int|array $initialValue
     */
    public function __construct($initialValue = 0)
    {
        $this->initialValue = is_array($initialValue) ? count($initialValue) : (int)$initialValue;
        $this->currentValue = $this->initialValue;
    }

    /**
     * @param $value
     *
     * @return $this
     * @author Andreas Glaser
     */
    public function increaseBy($value)
    {
        $this->currentValue += (int)$value;

        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     * @author Andreas Glaser
     */
    public function decreaseBy($value)
    {
        $this->currentValue -= (int)$value;

        return $this;
    }

    /**
     * @return \AndreasGlaser\Helpers\CounterHelper
     * @author Andreas Glaser
     */
    public function plusOne()
    {
        return $this->increaseBy(1);
    }

    /**
     * @return \AndreasGlaser\Helpers\CounterHelper
     * @author Andreas Glaser
     */
    public function minusOne()
    {
        return $this->decreaseBy(1);
    }

    /**
     * @return int
     * @author Andreas Glaser
     */
    public function getInitialValue()
    {
        return $this->initialValue;
    }

    /**
     * @return int
     * @author Andreas Glaser
     */
    public function getCurrentValue()
    {
        return $this->currentValue;
    }

    /**
     * @return int
     * @author Andreas Glaser
     */
    public function getDifference()
    {
        if ($this->initialValue === $this->currentValue) {
            return 0;
        }

        return abs($this->currentValue - $this->initialValue);
    }

    /**
     * @return string
     * @author Andreas Glaser
     */
    public function __toString()
    {
        return (string)$this->getCurrentValue();
    }
}