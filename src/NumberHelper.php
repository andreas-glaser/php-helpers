<?php

namespace AndreasGlaser\Helpers;

/**
 * NumberHelper provides utility methods for working with numbers.
 * 
 * This class contains methods for:
 * - Converting numbers to ordinal indicators (1st, 2nd, 3rd, etc.)
 */
class NumberHelper
{
    /**
     * Converts a number to its ordinal indicator suffix.
     * 
     * This method handles special cases:
     * - Numbers ending in 11, 12, 13 use 'th'
     * - Numbers ending in 1 use 'st'
     * - Numbers ending in 2 use 'nd'
     * - Numbers ending in 3 use 'rd'
     * - All other numbers use 'th'
     *
     * @param int|float $number The number to convert
     *
     * @return string The ordinal indicator suffix ('st', 'nd', 'rd', or 'th')
     */
    public static function ordinal($number)
    {
        if ($number % 100 > 10 && $number % 100 < 14) {
            return 'th';
        }

        switch ($number % 10) {
            case 1:
                return 'st';
            case 2:
                return 'nd';
            case 3:
                return 'rd';
            default:
                return 'th';
        }
    }
}
