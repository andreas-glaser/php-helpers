<?php

namespace AndreasGlaser\Helpers;

/**
 * Class ValueHelper
 *
 * @package AndreasGlaser\Helpers
 */
class ValueHelper
{
    /**
     * @param $string
     *
     * @return null
     */
    public static function emptyToNull(&$string)
    {
        return empty($string) ? null : $string;
    }

    /**
     * Checks if the given value is empty. This method is useful for PHP <= 5.4,
     * where you cannot pass function returns directly into empty() eg. empty(date('Y-m-d'))
     *
     * @param $value
     *
     * @return bool
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
     * Alias for DateHelper::isDateTime()
     *
     * @param mixed       $date
     * @param string|null $format
     *
     * @return bool
     */
    public static function isDateTime($date, string $format = null): bool
    {
        return DateHelper::isDateTime($date, $format);
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public static function isBool($value): bool
    {
        return is_bool($value);
    }

    /**
     * Check if value is TRUE.
     *
     * @param $value
     *
     * @return bool
     */
    public static function isTrue($value)
    {
        return self::isBool($value) && $value === true;
    }

    /**
     * * Check if value is FALSE.
     *
     * @param $value
     *
     * @return bool
     */
    public static function isFalse($value)
    {
        return self::isBool($value) && $value === false;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public static function isTrueLike($value)
    {
        return $value ? true : false;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public static function isFalseLike($value)
    {
        return !$value ? true : false;
    }
}