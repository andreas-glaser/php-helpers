<?php

namespace AndreasGlaser\Helpers;

/**
 * Class JsonHelper
 *
 * @package AndreasGlaser\Helpers
 * @author  Andreas Glaser
 */
class JsonHelper
{

    /**
     * Validates JSON input.
     *
     * @param $string
     *
     * @return bool
     * @author Andreas Glaser
     */
    public static function isValid($string)
    {
        if (is_int($string) || is_float($string)) {
            return true;
        }

        json_decode($string);

        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Encodes json string for the use in JavaScript.
     *
     * @param $string
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function encodeForJavaScript($string)
    {
        return json_encode($string, JSON_HEX_QUOT | JSON_HEX_APOS);
    }
}