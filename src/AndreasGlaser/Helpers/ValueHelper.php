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
}