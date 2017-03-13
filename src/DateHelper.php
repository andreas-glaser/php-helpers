<?php

namespace AndreasGlaser\Helpers;

use DateTimeZone;

/**
 * Class DateHelper
 *
 * @package AndreasGlaser\Helpers
 * @author  Andreas Glaser
 */
class DateHelper
{
    /**
     * @param string             $string
     * @param \DateTimeZone|null $timezone
     * @param mixed              $null
     *
     * @return \DateTime|null
     * @author Andreas Glaser
     */
    public static function stringToDateTime($string, DateTimeZone $timezone = null, $null = null)
    {
        return ValueHelper::isDateTime($string) ? new \DateTime($string, $timezone) : $null;
    }

    /**
     * Tries to format given input.
     *
     * @param string|\DateTime $dateTime
     * @param string           $format
     * @param null             $null
     *
     * @return null|string
     * @author Andreas Glaser
     */
    public static function formatOrNull($dateTime, $format = 'Y-m-d H:i:s', $null = null)
    {
        if ($dateTime instanceof \DateTime) {
            return $dateTime->format($format);
        } elseif (ValueHelper::isDateTime($dateTime)) {
            return static::stringToDateTime($dateTime)->format($format);
        } else {
            return $null;
        }
    }
}