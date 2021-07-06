<?php

namespace AndreasGlaser\Helpers\Exceptions;

class UnexpectedTypeException extends \RuntimeException
{
    public function __construct($value, string $expectedType)
    {
        parent::__construct(sprintf('Expected argument of type "%s", "%s" given', $expectedType, \is_object($value) ? \get_class($value) : \gettype($value)));
    }
}
