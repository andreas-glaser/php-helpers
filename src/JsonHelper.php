<?php

namespace AndreasGlaser\Helpers;

/**
 * JsonHelper provides utility methods for working with JSON data.
 * 
 * This class contains methods for:
 * - Validating JSON strings
 * - Encoding strings for safe use in JavaScript
 */
class JsonHelper
{
    /**
     * Validates if a value is valid JSON.
     * 
     * This method checks if:
     * - The input is a valid JSON string
     * - The input is a numeric value (which is always valid JSON)
     *
     * @param mixed $string The value to validate
     *
     * @return bool True if the value is valid JSON, false otherwise
     */
    public static function isValid($string)
    {
        if (\is_int($string) || \is_float($string)) {
            return true;
        }

        \json_decode($string ?? '');

        return JSON_ERROR_NONE === \json_last_error();
    }

    /**
     * Encodes a string for safe use in JavaScript.
     * 
     * This method:
     * - Converts quotes and apostrophes to their hex entities
     * - Ensures the string can be safely embedded in JavaScript code
     *
     * @param mixed $string The string to encode
     *
     * @return string The encoded string safe for JavaScript use
     */
    public static function encodeForJavaScript($string)
    {
        return \json_encode($string, JSON_HEX_QUOT | JSON_HEX_APOS);
    }
}
