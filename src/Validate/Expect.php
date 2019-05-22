<?php

namespace AndreasGlaser\Helpers\Validate;

use AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException;

/**
 * Class Expect
 *
 * @package AndreasGlaser\Helpers\Validate
 */
class Expect
{
    /**
     * /**
     * @param $value
     */
    public static function int($value)
    {
        if (!is_int($value)) {
            throw new UnexpectedTypeException($value, 'integer');
        }
    }

    /**
     * @param $value
     */
    public static function float($value)
    {
        if (!is_float($value)) {
            throw new UnexpectedTypeException($value, 'float');
        }
    }

    /**
     * @param $value
     */
    public static function numeric($value)
    {
        if (!is_numeric($value)) {
            throw new UnexpectedTypeException($value, 'numeric');
        }
    }

    /**
     * @param $value
     */
    public static function bool($value)
    {
        if (!is_bool($value)) {
            throw new UnexpectedTypeException($value, 'boolean');
        }
    }

    /**
     * @param $value
     */
    public static function str($value)
    {
        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }
    }

    /**
     * @param $value
     */
    public static function arr($value)
    {
        if (!is_array($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }
    }

    /**
     * @param $value
     */
    public static function obj($value)
    {
        if (!is_object($value)) {
            throw new UnexpectedTypeException($value, 'object');
        }
    }

    /**
     * @param $value
     */
    public static function res($value)
    {
        if (!is_resource($value)) {
            throw new UnexpectedTypeException($value, 'resource');
        }
    }

    /**
     * @param $value
     */
    public static function isCallable($value)
    {
        if (!is_callable($value)) {
            throw new UnexpectedTypeException($value, 'callable');
        }
    }

    /**
     * @param $value
     */
    public static function scalar($value)
    {
        if (!is_scalar($value)) {
            throw new UnexpectedTypeException($value, 'scalar');
        }
    }

    /**
     * @param $value
     */
    public static function null($value)
    {
        if (!is_null($value)) {
            throw new UnexpectedTypeException($value, 'null');
        }
    }
}