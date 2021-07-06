<?php

namespace AndreasGlaser\Helpers;

/**
 * Class JsonHelper.
 */
class JsonHelper
{
    /**
     * Validates JSON input.
     */
    public static function isValid(?string $string): bool
    {
        if (true === \is_int($string) || \is_float($string)) {
            return true;
        }

        json_decode($string);

        return JSON_ERROR_NONE === json_last_error();
    }

    /**
     * Encodes json string for the use in JavaScript.
     */
    public static function encodeForJavaScript(?string $string): string
    {
        return json_encode($string, JSON_HEX_QUOT | JSON_HEX_APOS);
    }
}
