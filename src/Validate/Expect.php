<?php

namespace AndreasGlaser\Helpers\Validate;

use AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException;

/**
 * Class Expect
 *
 * @package AndreasGlaser\Helpers\Validate
 * @author  Andreas Glaser
 */
class Expect
{
    /**
     * @param $value
     *
     * @author Andreas Glaser
     */
    public static function int($value)
    {
        if (!is_int($value)) {
            throw new UnexpectedTypeException($value, 'integer');
        }
    }

    /**
     * @param $value
     *
     * @author Andreas Glaser
     */
    public static function float($value)
    {
        if (!is_float($value)) {
            throw new UnexpectedTypeException($value, 'float');
        }
    }

    /**
     * @param $value
     *
     * @author Andreas Glaser
     */
    public static function bool($value)
    {
        if (!is_bool($value)) {
            throw new UnexpectedTypeException($value, 'boolean');
        }
    }

    /**
     * @param $value
     *
     * @author Andreas Glaser
     */
    public static function str($value)
    {
        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }
    }

    /**
     * @param $value
     *
     * @author Andreas Glaser
     */
    public static function arr($value)
    {
        if (!is_array($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }
    }

    /**
     * @param $value
     *
     * @author Andreas Glaser
     */
    public static function obj($value)
    {
        if (!is_object($value)) {
            throw new UnexpectedTypeException($value, 'object');
        }
    }

    /**
     * @param $value
     *
     * @author Andreas Glaser
     */
    public static function res($value)
    {
        if (!is_resource($value)) {
            throw new UnexpectedTypeException($value, 'resource');
        }
    }

    /**
     * @param $value
     *
     * @author Andreas Glaser
     */
    public static function isCallable($value)
    {
        if (!is_callable($value)) {
            throw new UnexpectedTypeException($value, 'callable');
        }
    }

    /**
     * @param $value
     *
     * @author Andreas Glaser
     */
    public static function scalar($value)
    {
        if (!is_scalar($value)) {
            throw new UnexpectedTypeException($value, 'scalar');
        }
    }
}