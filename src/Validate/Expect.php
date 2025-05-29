<?php

namespace AndreasGlaser\Helpers\Validate;

use AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException;

/**
 * Expect provides type validation methods that throw exceptions on type mismatches.
 * 
 * This class contains methods for validating that values match expected types:
 * - Basic types (int, float, string, bool)
 * - Complex types (array, object, resource)
 * - Special types (numeric, callable, scalar, null)
 * - Built-in PHP types (countable, iterable, finite, infinite, nan)
 * 
 * Each method throws UnexpectedTypeException if the value doesn't match the expected type.
 */
class Expect
{
    /**
     * Validates that a value is an integer.
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not an integer
     */
    public static function int($value): void
    {
        if (!\is_int($value)) {
            throw new UnexpectedTypeException($value, 'integer');
        }
    }

    /**
     * Validates that a value is a float.
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not a float
     */
    public static function float($value): void
    {
        if (!\is_float($value)) {
            throw new UnexpectedTypeException($value, 'float');
        }
    }

    /**
     * Validates that a value is numeric.
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not numeric
     */
    public static function numeric($value): void
    {
        if (!\is_numeric($value)) {
            throw new UnexpectedTypeException($value, 'numeric');
        }
    }

    /**
     * Validates that a value is a boolean.
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not a boolean
     */
    public static function bool($value): void
    {
        if (!\is_bool($value)) {
            throw new UnexpectedTypeException($value, 'boolean');
        }
    }

    /**
     * Validates that a value is a string.
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not a string
     */
    public static function str($value): void
    {
        if (!\is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }
    }

    /**
     * Validates that a value is an array.
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not an array
     */
    public static function arr($value): void
    {
        if (!\is_array($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }
    }

    /**
     * Validates that a value is an object.
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not an object
     */
    public static function obj($value): void
    {
        if (!\is_object($value)) {
            throw new UnexpectedTypeException($value, 'object');
        }
    }

    /**
     * Validates that a value is a resource.
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not a resource
     */
    public static function res($value): void
    {
        if (!\is_resource($value)) {
            throw new UnexpectedTypeException($value, 'resource');
        }
    }

    /**
     * Validates that a value is callable.
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not callable
     */
    public static function isCallable($value): void
    {
        if (!\is_callable($value)) {
            throw new UnexpectedTypeException($value, 'callable');
        }
    }

    /**
     * Validates that a value is scalar (int, float, string, or bool).
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not scalar
     */
    public static function scalar($value): void
    {
        if (!\is_scalar($value)) {
            throw new UnexpectedTypeException($value, 'scalar');
        }
    }

    /**
     * Validates that a value is null.
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not null
     */
    public static function null($value): void
    {
        if (!\is_null($value)) {
            throw new UnexpectedTypeException($value, 'null');
        }
    }

    /**
     * Validates that a value is countable (array or implements Countable).
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not countable
     */
    public static function countable($value): void
    {
        if (!\is_countable($value)) {
            throw new UnexpectedTypeException($value, 'countable');
        }
    }

    /**
     * Validates that a value is iterable (array or implements Traversable).
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not iterable
     */
    public static function iterable($value): void
    {
        if (!\is_iterable($value)) {
            throw new UnexpectedTypeException($value, 'iterable');
        }
    }

    /**
     * Validates that a value is a finite number (not infinite or NaN).
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not a finite number
     */
    public static function finite($value): void
    {
        if ((!\is_int($value) && !\is_float($value)) || !\is_finite($value)) {
            throw new UnexpectedTypeException($value, 'finite number');
        }
    }

    /**
     * Validates that a value is an infinite number.
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not infinite
     */
    public static function infinite($value): void
    {
        if (!\is_float($value) || !\is_infinite($value)) {
            throw new UnexpectedTypeException($value, 'infinite number');
        }
    }

    /**
     * Validates that a value is NaN (Not a Number).
     *
     * @param mixed $value The value to validate
     *
     * @throws UnexpectedTypeException If the value is not NaN
     */
    public static function nan($value): void
    {
        if (!\is_float($value) || !\is_nan($value)) {
            throw new UnexpectedTypeException($value, 'NaN');
        }
    }
}
