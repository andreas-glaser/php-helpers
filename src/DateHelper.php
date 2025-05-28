<?php

namespace AndreasGlaser\Helpers;

use DateTimeZone;

/**
 * DateHelper provides utility methods for working with dates and times.
 * 
 * This class contains methods for validating, formatting, and calculating
 * differences between dates and times, with support for various formats
 * and timezone handling.
 */
class DateHelper
{
    /**
     * Checks if a value is a valid datetime.
     *
     * @param mixed $date The value to check
     * @param string|null $format Optional format to validate against
     *
     * @return bool True if the value is a valid datetime
     */
    public static function isDateTime($date, string $format = null): bool
    {
        if ($date instanceof \DateTime) {
            return true;
        }

        if (true === \is_string($date)) {
            if (true === StringHelper::isBlank($date)) {
                return false;
            }
        } else {
            return false;
        }

        if ($format) {
            $dateTime = \DateTime::createFromFormat($format, $date);
        } else {
            try {
                $dateTime = new \DateTime($date);
            } catch (\Throwable $e) {
                return false;
            }
        }

        if (false === $dateTime instanceof \DateTime) {
            return false;
        }

        $errors = \DateTime::getLastErrors();
        return false === $errors || 0 === $errors['warning_count'];
    }

    /**
     * Converts a string to a DateTime object.
     *
     * @param mixed $string The string to convert
     * @param DateTimeZone|null $timezone The timezone to use
     * @param mixed $null The value to return if conversion fails
     *
     * @return \DateTime|null The DateTime object or null if conversion fails
     *
     * @throws \Exception If the string cannot be converted to a DateTime
     */
    public static function stringToDateTime($string, DateTimeZone $timezone = null, $null = null)
    {
        return self::isDateTime($string) ? new \DateTime($string, $timezone) : $null;
    }

    /**
     * Formats a datetime value or returns null if invalid.
     *
     * @param mixed $dateTime The datetime value to format
     * @param string $format The format to use (default: 'Y-m-d H:i:s')
     * @param mixed $null The value to return if formatting fails
     *
     * @return string|null The formatted datetime or null if invalid
     *
     * @throws \Exception If the datetime cannot be formatted
     */
    public static function formatOrNull($dateTime, $format = 'Y-m-d H:i:s', $null = null)
    {
        if ($dateTime instanceof \DateTime) {
            return $dateTime->format($format);
        } elseif (self::isDateTime($dateTime)) {
            return static::stringToDateTime($dateTime)->format($format);
        } else {
            return $null;
        }
    }

    /**
     * Calculates the difference in hours between two datetimes.
     *
     * @param \DateTime $dateTime1 The first datetime
     * @param \DateTime $dateTime2 The second datetime
     *
     * @return int The number of hours between the datetimes
     */
    public static function diffHours(\DateTime $dateTime1, \DateTime $dateTime2): int
    {
        $diff = $dateTime1->diff($dateTime2);
        $hours = $diff->h;
        $hours = $hours + ($diff->days * 24);

        return (int)$hours;
    }

    /**
     * Calculates the difference in days between two datetimes.
     *
     * @param \DateTime $dateTime1 The first datetime
     * @param \DateTime $dateTime2 The second datetime
     *
     * @return int The number of days between the datetimes
     */
    public static function diffDays(\DateTime $dateTime1, \DateTime $dateTime2): int
    {
        $diff = $dateTime1->diff($dateTime2);

        return (int)$diff->format('%a');
    }

    /**
     * Calculates the difference in months between two datetimes.
     *
     * @param \DateTime $dateTime1 The first datetime
     * @param \DateTime $dateTime2 The second datetime
     *
     * @return int The number of months between the datetimes
     */
    public static function diffMonths(\DateTime $dateTime1, \DateTime $dateTime2): int
    {
        $diff = $dateTime1->diff($dateTime2);

        return ((int)$diff->format('%y') * 12) + (int)$diff->format('%m');
    }

    /**
     * Calculates the difference in years between two datetimes.
     *
     * @param \DateTime $dateTime1 The first datetime
     * @param \DateTime $dateTime2 The second datetime
     *
     * @return int The number of years between the datetimes
     */
    public static function diffYears(\DateTime $dateTime1, \DateTime $dateTime2): int
    {
        $diff = $dateTime1->diff($dateTime2);

        return (int)$diff->y;
    }
}
