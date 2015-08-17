<?php

namespace AndreasGlaser\Helpers;

/**
 * Class TimerHelper
 *
 * @package Helpers
 *
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
}