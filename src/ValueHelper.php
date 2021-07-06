<?php

namespace AndreasGlaser\Helpers;

/**
 * Class ValueHelper.
 */
class ValueHelper
{
    /**
     * @see https://www.php.net/manual/en/language.operators.comparison.php
     */
    public static function emptyToNull($value)
    {
        return $value ?: null;
    }

    /**
     * Checks if the given value is empty. This method is useful for PHP <= 5.4,
     * where you cannot pass function returns directly into empty() eg. empty(date('Y-m-d')).
     */
    public static function isEmpty($value): bool
    {
        return empty($value);
    }

    /**
     * Checks if given value is of type "integer".
     */
    public static function isInteger($value): bool
    {
        if (true === \is_int($value)) {
            return true;
        } elseif (false === \is_string($value)) {
            return false;
        }

        return preg_match('/^\d+$/', $value) > 0;
    }

    /**
     * Checks if given value is of type "float".
     */
    public static function isFloat($value): bool
    {
        if (true === \is_float($value)) {
            return true;
        } elseif (false === \is_string($value)) {
            return false;
        }

        return preg_match('/^[0-9]+\.[0-9]+$/', $value) > 0;
    }

    public static function isBool($value): bool
    {
        return \is_bool($value);
    }

    /**
     * Check if value is TRUE.
     */
    public static function isTrue($value): bool
    {
        return true === $value;
    }

    /**
     * Check if value is FALSE.
     */
    public static function isFalse($value): bool
    {
        return false === $value;
    }

    public static function isTrueLike($value): bool
    {
        return (bool)$value;
    }

    public static function isFalseLike($value): bool
    {
        return !$value;
    }
}
