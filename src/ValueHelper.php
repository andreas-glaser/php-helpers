<?php

namespace AndreasGlaser\Helpers;

/**
 * ValueHelper provides utility methods for type checking and value validation.
 * 
 * This class contains methods for checking various data types and values,
 * including integers, floats, booleans, and datetime values.
 */
class ValueHelper
{
    /**
     * Converts an empty value to null.
     *
     * @param mixed $string The value to check and convert
     *
     * @return mixed|null The original value if not empty, null otherwise
     */
    public static function emptyToNull(&$string)
    {
        return empty($string) ? null : $string;
    }

    /**
     * Checks if the given value is empty.
     * 
     * This method is useful for PHP <= 5.4, where you cannot pass function returns
     * directly into empty() eg. empty(date('Y-m-d')).
     *
     * @param mixed $value The value to check
     *
     * @return bool True if the value is empty, false otherwise
     */
    public static function isEmpty($value)
    {
        return empty($value);
    }

    /**
     * Checks if given value is of type "integer".
     * 
     * This method checks both actual integers and string representations of integers.
     *
     * @param mixed $value The value to check
     *
     * @return bool True if the value is an integer or a string containing only digits
     */
    public static function isInteger($value)
    {
        if (\is_int($value)) {
            return true;
        } elseif (!\is_string($value)) {
            return false;
        }

        return \preg_match('/^\d+$/', $value) > 0;
    }

    /**
     * Checks if given value is of type "float".
     * 
     * This method checks both actual floats and string representations of floats.
     *
     * @param mixed $value The value to check
     *
     * @return bool True if the value is a float or a string containing a valid float format
     */
    public static function isFloat($value)
    {
        if (\is_float($value)) {
            return true;
        } elseif (!\is_string($value)) {
            return false;
        }

        return \preg_match('/^[0-9]+\.[0-9]+$/', $value) > 0;
    }

    /**
     * Checks if the given value is a valid datetime.
     *
     * @param mixed $date The value to check
     * @param string|null $format Optional format to validate against
     *
     * @return bool True if the value is a valid datetime
     */
    public static function isDateTime($date, string $format = null): bool
    {
        return DateHelper::isDateTime($date, $format);
    }

    /**
     * Checks if the given value is a boolean.
     *
     * @param mixed $value The value to check
     *
     * @return bool True if the value is a boolean
     */
    public static function isBool($value): bool
    {
        return \is_bool($value);
    }

    /**
     * Checks if the value is strictly TRUE.
     *
     * @param mixed $value The value to check
     *
     * @return bool True if the value is a boolean and equals true
     */
    public static function isTrue($value)
    {
        return self::isBool($value) && true === $value;
    }

    /**
     * Checks if the value is strictly FALSE.
     *
     * @param mixed $value The value to check
     *
     * @return bool True if the value is a boolean and equals false
     */
    public static function isFalse($value)
    {
        return self::isBool($value) && false === $value;
    }

    /**
     * Checks if the value evaluates to true in a boolean context.
     *
     * @param mixed $value The value to check
     *
     * @return bool True if the value evaluates to true
     */
    public static function isTrueLike($value)
    {
        return $value ? true : false;
    }

    /**
     * Checks if the value evaluates to false in a boolean context.
     *
     * @param mixed $value The value to check
     *
     * @return bool True if the value evaluates to false
     */
    public static function isFalseLike($value)
    {
        return !$value ? true : false;
    }
}
