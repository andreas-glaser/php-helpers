<?php

namespace AndreasGlaser\Helpers;

use AndreasGlaser\Helpers\Interfaces\FactoryInterface;

class CounterHelper implements FactoryInterface
{
    protected int $initialValue = 0;
    protected int $currentValue = 0;

    public static function f(int $initialValue = 0): self
    {
        return new self($initialValue);
    }

    public function __construct(int $initialValue = 0)
    {
        $this->initialValue = $initialValue;
        $this->currentValue = $this->initialValue;
    }

    public function increaseBy(int $value): self
    {
        $this->currentValue += $value;

        return $this;
    }

    public function decreaseBy(int $value): self
    {
        $this->currentValue -= $value;

        return $this;
    }

    public function plusOne(): self
    {
        return $this->increaseBy(1);
    }

    public function minusOne(): self
    {
        return $this->decreaseBy(1);
    }

    public function getInitialValue(): int
    {
        return $this->initialValue;
    }

    public function getCurrentValue(): int
    {
        return $this->currentValue;
    }

    public function getDifference(): int
    {
        if ($this->initialValue === $this->currentValue) {
            return 0;
        }

        return abs($this->currentValue - $this->initialValue);
    }

    public function __toString(): string
    {
        return (string)$this->getCurrentValue();
    }
}
