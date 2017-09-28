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

    /**
     * @param \DateTime $dateTime1
     * @param \DateTime $dateTime2
     *
     * @return int
     */
    public static function diffHours(\DateTime $dateTime1, \DateTime $dateTime2): int
    {
        $diff = $dateTime1->diff($dateTime2);
        $hours = $diff->h;
        $hours = $hours + ($diff->days * 24);

        return (int)$hours;
    }

    /**
     * @param \DateTime $dateTime1
     * @param \DateTime $dateTime2
     *
     * @return int
     */
    public static function diffDays(\DateTime $dateTime1, \DateTime $dateTime2): int
    {
        $diff = $dateTime1->diff($dateTime2);

        return (int)$diff->format('%a');
    }

    /**
     * @param \DateTime $dateTime1
     * @param \DateTime $dateTime2
     *
     * @return int
     */
    public static function diffMonths(\DateTime $dateTime1, \DateTime $dateTime2): int
    {
        $diff = $dateTime1->diff($dateTime2);

        return ((int)$diff->format('%y') * 12) + (int)$diff->format('%m');
    }

    /**
     * @param \DateTime $dateTime1
     * @param \DateTime $dateTime2
     *
     * @return int
     */
    public static function diffYears(\DateTime $dateTime1, \DateTime $dateTime2): int
    {
        $diff = $dateTime1->diff($dateTime2);

        return (int)$diff->y;
    }
}