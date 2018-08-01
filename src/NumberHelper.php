<?php

namespace AndreasGlaser\Helpers;

/**
 * Class NumberHelper
 *
 * @package AndreasGlaser\Helpers
 */
class NumberHelper
{
    /**
     * @param $number
     *
     * @return string
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