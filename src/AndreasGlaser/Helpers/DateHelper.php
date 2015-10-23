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
     * @param               $string
     * @param \DateTimeZone $timezone
     *
     * @return \DateTime|null
     * @author Andreas Glaser
     */
    public static function stringToDateTime($string, DateTimeZone $timezone = null)
    {
        return ValueHelper::isDateTime($string) ? new \DateTime($string, $timezone) : null;
    }
}