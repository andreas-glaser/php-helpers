<?php

namespace AndreasGlaser\Helpers\Exceptions;

/**
 * Class UnexpectedTypeException
 * 
 * Exception thrown when a value is of an unexpected type.
 * Extends RuntimeException to provide detailed information about the expected and actual types.
 */
class UnexpectedTypeException extends \RuntimeException
{
    /**
     * UnexpectedTypeException constructor
     *
     * @param mixed  $value        The value that was of an unexpected type
     * @param string $expectedType The type that was expected
     * 
     * @throws \RuntimeException When the value is of an unexpected type
     */
    public function __construct($value, $expectedType)
    {
        parent::__construct(\sprintf('Expected argument of type "%s", "%s" given', $expectedType, \is_object($value) ? \get_class($value) : \gettype($value)));
    }
}
