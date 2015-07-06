<?php

namespace AndreasGlaser\Helpers;

class JsonHelper
{
    /**
     * @param $string
     *
     * @return bool
     *
     * @author Andreas Glaser
     * @source http://andreas.glaser.me/2013/05/27/php-check-if-string-is-json/
     */
    public static function isValid($string)
    {
        // make sure provided input is of type string
        if (!is_string($string)) {
            return false;
        }

        // trim white spaces
        $string = trim($string);

        // get first character
        $firstChar = substr($string, 0, 1);

        // get last character
        $lastChar = substr($string, -1);

        // check if there is a first and last character
        if (!$firstChar || !$lastChar) {
            return false;
        }

        // make sure first character is either { or [
        if ($firstChar !== '{' && $firstChar !== '[') {
            return false;
        }

        // make sure last character is either } or ]
        if ($lastChar !== '}' && $lastChar !== ']') {
            return false;
        }

        // let's leave the rest to PHP.
        // try to decode string
        json_decode($string);

        // check if error occurred
        $isValid = json_last_error() === JSON_ERROR_NONE;

        return $isValid;
    }

    /**
     * Encodes json string for the use in JavaScript.
     *
     * @param $string
     *
     * @return string
     *
     * @author Andreas Glaser
     */
    public static function encodeForJavaScript($string)
    {
        return json_encode($string, JSON_HEX_QUOT | JSON_HEX_APOS);
    }
}