<?php

namespace AndreasGlaser\Helpers;

/**
 * Class StringHelper
 *
 * @package Helpers
 *
 * @author  Andreas Glaser
 */
class StringHelper
{
    /**
     * @param      $string
     * @param      $stringToMach
     * @param bool $caseSensitive
     *
     * @return bool
     *
     * @author Andreas Glaser
     */
    public static function is($string, $stringToMach, $caseSensitive = true)
    {
        if ($caseSensitive === false) {
            return strcasecmp($string, $stringToMach) === 0;
        }

        return strcmp($string, $stringToMach) === 0;
    }

    /**
     * @param       $string
     * @param array $stingsToCompare
     * @param bool  $caseSensitive
     *
     * @return bool|string
     *
     * @author Andreas Glaser
     */
    public static function isOneOf($string, array $stingsToCompare, $caseSensitive = true)
    {

        foreach ($stingsToCompare AS $compareTo) {
            if (self::is($string, $compareTo, $caseSensitive)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param        $haystack
     * @param        $needle
     * @param bool   $caseSensitive
     * @param string $encoding
     *
     * @return bool
     *
     * @author Andreas Glaser
     */
    public static function contains($haystack, $needle, $caseSensitive = true, $encoding = 'UTF-8')
    {
        if ($caseSensitive === false) {
            return mb_stristr($haystack, $needle, null, $encoding) !== false;
        }

        return mb_strstr($haystack, $needle, null, $encoding) !== false;
    }

    /**
     * @param        $haystack
     * @param        $needle
     * @param bool   $caseSensitive
     * @param string $encoding
     *
     * @return bool
     *
     * @author Andreas Glaser
     */
    public static function startsWith($haystack, $needle, $caseSensitive = true, $encoding = 'UTF-8')
    {
        if ($caseSensitive === false) {
            return strncasecmp($haystack, $needle, mb_strlen($needle, $encoding)) === 0;
        }

        return strncmp($haystack, $needle, mb_strlen($needle, $encoding)) === 0;
    }

    /**
     * @param        $haystack
     * @param        $needle
     * @param bool   $caseSensitive
     * @param string $encoding
     *
     * @return bool
     *
     * @author Andreas Glaser
     */
    public static function endsWith($haystack, $needle, $caseSensitive = true, $encoding = 'UTF-8')
    {
        // get length of needle
        $length = mb_strlen($needle, $encoding);

        // always return true if needle is empty
        if ($length === 0) {
            return true;
        }

        if ($caseSensitive === false) {
            return strcasecmp(mb_substr($haystack, -$length, null, $encoding), $needle) === 0;
        }

        return strcmp(mb_substr($haystack, -$length, null, $encoding), $needle) === 0;
    }

    /**
     * @deprecated Please use ValueHelper::isDateTime($value); instead
     */
    public static function isDateTime($string)
    {
        return ValueHelper::isDateTime($string);
    }

    /**
     * @param       $string
     * @param array $chars
     *
     * @return string
     *
     * @author Andreas Glaser
     */
    public static function trimMulti($string, array $chars)
    {
        foreach ($chars as $char) {
            $string = trim($string, $char);
        }

        return $string;
    }

    /**
     * @param       $string
     * @param array $chars
     *
     * @return string
     *
     * @author Andreas Glaser
     */
    public static function lTrimMulti($string, array $chars)
    {
        foreach ($chars as $char) {
            $string = ltrim($string, $char);
        }

        return $string;
    }

    /**
     * @param       $string
     * @param array $chars
     *
     * @return string
     *
     * @author Andreas Glaser
     */
    public static function rTrimMulti($string, array $chars)
    {
        foreach ($chars as $char) {
            $string = rtrim($string, $char);
        }

        return $string;
    }

    /**
     * Turns camel case into underscore case.
     *
     * @param $string
     *
     * @return string
     *
     * @author Andreas Glaser
     */
    public static function camelToUnderscore($string)
    {
        if (is_numeric($string)) {
            return $string;
        }

        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $ret);
    }

    /**
     * @param        $string
     * @param string $replaceWith
     *
     * @return mixed
     *
     * @author Andreas Glaser
     */
    public static function removeLineBreaks($string, $replaceWith = ' ')
    {
        return preg_replace('/[\r\n]+/', $replaceWith, $string);
    }

    /**
     * @param $string
     *
     * @return mixed
     *
     * @author Andreas Glaser
     */
    public static function removeRedundantWhiteSpaces($string)
    {
        return preg_replace('/\s+/', ' ', $string);
    }

    /**
     * @param $string
     *
     * @return mixed
     *
     * @author Andreas Glaser
     */
    public static function replaceWhiteSpacesWithUnderscores($string)
    {
        return str_replace(' ', '_', $string);
    }

    /**
     * @param $string
     *
     * @return string
     *
     * @author Andreas Glaser
     */
    public static function machineReadable($string)
    {
        return trim(self::replaceWhiteSpacesWithUnderscores(strtolower(self::removeRedundantWhiteSpaces(self::removeLineBreaks($string)))));
    }

    /**
     * @param $string
     * @param $stringToAppend
     *
     * @return string
     *
     * @author Andreas Glaser
     */
    public static function append($string, $stringToAppend)
    {
        return $string . $stringToAppend;
    }

    /**
     * @param $string
     * @param $stringToPrepend
     *
     * @return string
     *
     * @author Andreas Glaser
     */
    public static function prepend($string, $stringToPrepend)
    {
        return $stringToPrepend . $string;
    }

    /**
     * @param $string
     * @param $char
     *
     * @return mixed
     *
     * @author Andreas Glaser
     */
    public static function removeChar($string, $char)
    {
        return str_replace($char, null, $string);
    }

    /**
     * @param       $string
     * @param array $chars
     *
     * @return mixed
     */
    public static function removeChars($string, array $chars)
    {
        foreach ($chars AS $char) {
            $string = self::removeChar($string, $char);
        }

        return $string;
    }

    /**
     * @param      $delimiter
     * @param      $string
     *
     * @return array
     *
     * @author Andreas Glaser
     */
    public static function explodeAndTrim($delimiter, $string)
    {
        $return = [];
        $pieces = explode($delimiter, $string);

        foreach ($pieces AS $piece) {
            $return[] = trim($piece);
        }

        return $return;
    }

    /**
     * Replaces multiple parts of a string.
     *
     * @param       $subject
     * @param array $replacementMap
     * @param bool  $caseSensitive
     *
     * @return mixed
     *
     * @author Andreas Glaser
     */
    public static function replace($subject, array $replacementMap, $caseSensitive = true)
    {
        foreach ($replacementMap AS $search => $replace) {
            if ($caseSensitive) {
                $subject = str_replace($search, $replace, $subject);
            } else {
                $subject = str_ireplace($search, $replace, $subject);
            }
        }

        return $subject;
    }

    /**
     * Limits a phrase to a given number of words.
     *
     *     $text = static::limit_words($text);
     *
     * @param   string  $str      phrase to limit words of
     * @param   integer $limit    number of words to limit to
     * @param   string  $end_char end character or entity
     *
     * @return  string
     */
    public static function limitWords($str, $limit = 100, $end_char = null)
    {
        $limit = (int)$limit;
        $end_char = ($end_char === null) ? '…' : $end_char;

        if (trim($str) === '') {
            return $str;
        }

        if ($limit <= 0) {
            return $end_char;
        }

        preg_match('/^\s*+(?:\S++\s*+){1,' . $limit . '}/u', $str, $matches);

        // Only attach the end character if the matched string is shorter
        // than the starting string.
        return rtrim($matches[0]) . ((strlen($matches[0]) === strlen($str)) ? '' : $end_char);
    }

    /**
     * Limits a phrase to a given number of characters.
     *
     *     $text = static::limit_chars($text);
     *
     * @param   string  $str            phrase to limit characters of
     * @param   integer $limit          number of characters to limit to
     * @param   string  $end_char       end character or entity
     * @param   boolean $preserve_words enable or disable the preservation of words while limiting
     *
     * @return  string
     * @uses    strlen
     */
    public static function limitChars($str, $limit = 100, $end_char = null, $preserve_words = false)
    {
        $end_char = ($end_char === null) ? '…' : $end_char;

        $limit = (int)$limit;

        if (trim($str) === '' OR strlen($str) <= $limit) {
            return $str;
        }

        if ($limit <= 0) {
            return $end_char;
        }

        if ($preserve_words === false) {
            return rtrim(substr($str, 0, $limit)) . $end_char;
        }

        // Don't preserve words. The limit is considered the top limit.
        // No strings with a length longer than $limit should be returned.
        if (!preg_match('/^.{0,' . $limit . '}\s/us', $str, $matches)) {
            return $end_char;
        }

        return rtrim($matches[0]) . ((strlen($matches[0]) === strlen($str)) ? '' : $end_char);
    }

    /**
     * @param string $prefix
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function getIncrementalId($prefix = '__undefined__')
    {
        static $indexes = [];

        if (!array_key_exists($prefix, $indexes)) {
            $indexes[$prefix] = -1;
        }

        $indexes[$prefix]++;

        return ($prefix != '__undefined__' ? $prefix : null) . $indexes[$prefix];
    }

    /**
     * Checks if a string is blank. " " is considered as such.
     *
     * @param $string
     *
     * @return boolean
     * @author Andreas Glaser
     */
    public static function isBlank($string)
    {
        return !strlen(trim((string)$string)) > 0;
    }
}

// shortcut for strtr
if (!function_exists('__')) {

    function __($string, array $params = null)
    {

        if (!empty($params)) {
            return $string;
        }

        return strtr($string, $params);
    }
}