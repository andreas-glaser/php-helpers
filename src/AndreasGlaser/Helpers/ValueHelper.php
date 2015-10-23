<?php

namespace AndreasGlaser\Helpers;

/**
 * Class ValueHelper
 *
 * @package AndreasGlaser\Helpers
 * @author  Andreas Glaser
 */
class ValueHelper
{
    /**
     * @param $string
     *
     * @return null
     * @author Andreas Glaser
     */
    public static function emptyToNull(&$string)
    {
        return empty($string) ? null : $string;
    }

    /**
     * @param $value
     *
     * @return bool
     * @author Andreas Glaser
     */
    public static function isEmpty($value)
    {
        return empty($value);
    }

    /**
     * Checks if given value is of type "integer"
     *
     * @param $value
     *
     * @return bool
     * @author Andreas Glaser
     */
    public static function isInteger($value)
    {
        if (is_int($value)) {
            return true;
        } elseif (!is_string($value)) {
            return false;
        }

        return preg_match('/^\d+$/', $value) > 0;
    }

    /**
     * Checks if given value is of type "float"
     *
     * @param $value
     *
     * @return bool
     * @author Andreas Glaser
     */
    public static function isFloat($value)
    {
        if (is_float($value)) {
            return true;
        } elseif (!is_string($value)) {
            return false;
        }

        return preg_match('/^[0-9]+\.[0-9]+$/', $value) > 0;
    }

    /**
     * Checks if given value is a valid PHP "datetime"
     *
     * @param $string
     *
     * @return bool
     * @author Andreas Glaser
     */
    public static function isDateTime($string)
    {
        return is_string($string) ? (bool)strtotime($string) : false;
    }

}