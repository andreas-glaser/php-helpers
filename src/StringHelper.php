<?php

namespace AndreasGlaser\Helpers;

/**
 * StringHelper provides utility methods for string manipulation and comparison.
 * 
 * This class contains static methods for common string operations such as:
 * - String comparison and matching
 * - String transformation (camelCase to underscore, etc.)
 * - String cleaning and formatting
 * - String manipulation (append, prepend, remove)
 */
class StringHelper
{
    /**
     * Checks if two strings are equal.
     *
     * @param string $string The first string to compare
     * @param string $stringToMach The second string to compare
     * @param bool $caseSensitive Whether the comparison should be case-sensitive
     *
     * @return bool True if the strings are equal, false otherwise
     */
    public static function is($string, $stringToMach, $caseSensitive = true): bool
    {
        if (false === $caseSensitive) {
            return 0 === \strcasecmp($string ?? '', $stringToMach ?? '');
        }

        return 0 === \strcmp($string ?? '', $stringToMach ?? '');
    }

    /**
     * Checks if a string matches any of the strings in the given array.
     *
     * @param string $string The string to check
     * @param array $stingsToCompare Array of strings to compare against
     * @param bool $caseSensitive Whether the comparison should be case-sensitive
     *
     * @return bool True if the string matches any of the comparison strings, false otherwise
     */
    public static function isOneOf($string, array $stingsToCompare, $caseSensitive = true): bool
    {
        foreach ($stingsToCompare as $compareTo) {
            if (self::is($string, $compareTo, $caseSensitive)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if a string contains another string.
     *
     * @param string $haystack The string to search in
     * @param string $needle The string to search for
     * @param bool $caseSensitive Whether the search should be case-sensitive
     * @param string $encoding The character encoding to use
     *
     * @return bool True if the needle is found in the haystack, false otherwise
     */
    public static function contains($haystack, $needle, $caseSensitive = true, $encoding = 'UTF-8'): bool
    {
        if (false === $caseSensitive) {
            return false !== \mb_stristr($haystack ?? '', $needle ?? '', false, $encoding);
        }

        return false !== \mb_strstr($haystack ?? '', $needle ?? '', false, $encoding);
    }

    /**
     * Checks if a string starts with another string.
     *
     * @param string $haystack The string to check
     * @param string $needle The string to look for at the start
     * @param bool $caseSensitive Whether the comparison should be case-sensitive
     * @param string $encoding The character encoding to use
     *
     * @return bool True if the haystack starts with the needle, false otherwise
     */
    public static function startsWith($haystack, $needle, bool $caseSensitive = true, $encoding = 'UTF-8'): bool
    {
        if (false === $caseSensitive) {
            return 0 === \strncasecmp($haystack ?? '', $needle ?? '', \mb_strlen($needle ?? '', $encoding));
        }

        return 0 === \strncmp($haystack ?? '', $needle ?? '', \mb_strlen($needle ?? '', $encoding));
    }

    /**
     * Checks if a string ends with another string.
     *
     * @param string $haystack The string to check
     * @param string $needle The string to look for at the end
     * @param bool $caseSensitive Whether the comparison should be case-sensitive
     * @param string $encoding The character encoding to use
     *
     * @return bool True if the haystack ends with the needle, false otherwise
     */
    public static function endsWith($haystack, $needle, bool $caseSensitive = true, $encoding = 'UTF-8'): bool
    {
        // get length of needle
        $length = \mb_strlen($needle ?? '', $encoding);

        // always return true if needle is empty
        if (0 === $length) {
            return true;
        }

        if (false === $caseSensitive) {
            return 0 === \strcasecmp(\mb_substr($haystack ?? '', -$length, null, $encoding), $needle ?? '');
        }

        return 0 === \strcmp(\mb_substr($haystack ?? '', -$length, null, $encoding), $needle ?? '');
    }

    /**
     * Checks if a string is a valid datetime.
     *
     * @deprecated Please use ValueHelper::isDateTime($value) instead
     * @param string $string The string to check
     *
     * @return bool True if the string is a valid datetime, false otherwise
     */
    public static function isDateTime($string): bool
    {
        return ValueHelper::isDateTime($string);
    }

    /**
     * Trims multiple characters from both ends of a string.
     *
     * @param string $string The string to trim
     * @param array $chars Array of characters to trim
     *
     * @return string The trimmed string
     */
    public static function trimMulti($string, array $chars): string
    {
        foreach ($chars as $char) {
            $string = \trim($string, $char);
        }

        return $string;
    }

    /**
     * Trims multiple characters from the left end of a string.
     *
     * @param string $string The string to trim
     * @param array $chars Array of characters to trim
     *
     * @return string The trimmed string
     */
    public static function lTrimMulti($string, array $chars): string
    {
        foreach ($chars as $char) {
            $string = \ltrim($string, $char);
        }

        return $string;
    }

    /**
     * Trims multiple characters from the right end of a string.
     *
     * @param string $string The string to trim
     * @param array $chars Array of characters to trim
     *
     * @return string The trimmed string
     */
    public static function rTrimMulti($string, array $chars): string
    {
        foreach ($chars as $char) {
            $string = \rtrim($string, $char);
        }

        return $string;
    }

    /**
     * Converts a camelCase string to underscore_case.
     *
     * @param string $string The string to convert
     *
     * @return string The converted string
     */
    public static function camelToUnderscore($string): string
    {
        if (\is_numeric($string)) {
            return $string;
        }

        \preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == \strtoupper($match) ? \strtolower($match) : \lcfirst($match);
        }

        return \implode('_', $ret);
    }

    /**
     * Removes line breaks from a string.
     *
     * @param string $string The string to process
     * @param string $replaceWith The string to replace line breaks with
     *
     * @return string The processed string
     */
    public static function removeLineBreaks($string, $replaceWith = ' '): string
    {
        return \preg_replace('/[\r\n]+/', $replaceWith, $string);
    }

    /**
     * Removes redundant whitespace from a string.
     *
     * @param string $string The string to process
     *
     * @return string The processed string with single spaces
     */
    public static function removeRedundantWhiteSpaces($string): string
    {
        return \preg_replace('/\s+/', ' ', $string);
    }

    /**
     * Replaces all whitespace characters with underscores.
     *
     * @param string $string The string to process
     *
     * @return string The processed string
     */
    public static function replaceWhiteSpacesWithUnderscores($string): string
    {
        return \str_replace(' ', '_', $string);
    }

    /**
     * Converts a string to a machine-readable format.
     * Removes line breaks, redundant spaces, and converts to lowercase with underscores.
     *
     * @param string $string The string to convert
     *
     * @return string The machine-readable string
     */
    public static function machineReadable($string): string
    {
        return \trim(self::replaceWhiteSpacesWithUnderscores(\strtolower(self::removeRedundantWhiteSpaces(self::removeLineBreaks($string)))));
    }

    /**
     * Appends a string to another string.
     *
     * @param string $string The base string
     * @param string $stringToAppend The string to append
     *
     * @return string The concatenated string
     */
    public static function append($string, $stringToAppend): string
    {
        return $string . $stringToAppend;
    }

    /**
     * Prepends a string to another string.
     *
     * @param string $string The base string
     * @param string $stringToPrepend The string to prepend
     *
     * @return string The concatenated string
     */
    public static function prepend($string, $stringToPrepend): string
    {
        return $stringToPrepend . $string;
    }

    /**
     * Removes a specific character from a string.
     *
     * @param string $string The string to process
     * @param string $char The character to remove
     *
     * @return string The processed string
     */
    public static function removeChar($string, $char): string
    {
        return \str_replace($char, null, $string);
    }

    /**
     * Removes multiple characters from a string.
     *
     * @param string $string The string to process
     * @param array $chars Array of characters to remove
     *
     * @return string The processed string
     */
    public static function removeChars($string, array $chars): string
    {
        foreach ($chars as $char) {
            $string = self::removeChar($string, $char);
        }

        return $string;
    }

    /**
     * Explodes a string by delimiter and trims each resulting element.
     *
     * @param string $delimiter The delimiter to split by
     * @param string $string The string to split
     *
     * @return array Array of trimmed strings
     */
    public static function explodeAndTrim($delimiter, $string): array
    {
        $return = [];
        $pieces = \explode($delimiter, $string);

        foreach ($pieces as $piece) {
            $return[] = \trim($piece);
        }

        return $return;
    }

    /**
     * Replaces multiple strings in a subject string.
     *
     * @param string $subject The string to perform replacements on
     * @param array $replacementMap Array of search => replace pairs
     * @param bool $caseSensitive Whether the search should be case-sensitive
     *
     * @return string The processed string
     */
    public static function replace($subject, array $replacementMap, $caseSensitive = true): string
    {
        foreach ($replacementMap as $search => $replace) {
            if ($caseSensitive) {
                $subject = \str_replace($search, $replace, $subject);
            } else {
                $subject = \str_ireplace($search, $replace, $subject);
            }
        }

        return $subject;
    }

    /**
     * Limits a string to a specific number of words.
     *
     * @param string $str The string to limit
     * @param int $limit Maximum number of words
     * @param string|null $end_char String to append if the string is truncated
     *
     * @return string The truncated string
     */
    public static function limitWords($str, $limit = 100, $end_char = null): string
    {
        $limit = (int)$limit;
        $end_char = (null === $end_char) ? '…' : $end_char;

        if ('' === \trim($str)) {
            return $str;
        }

        if ($limit <= 0) {
            return $end_char;
        }

        \preg_match('/^\s*+(?:\S++\s*+){1,' . $limit . '}/u', $str, $matches);

        // Only attach the end character if the matched string is shorter
        // than the starting string.
        return \rtrim($matches[0]) . ((\strlen($matches[0]) === \strlen($str)) ? '' : $end_char);
    }

    /**
     * Limits a string to a specific number of characters.
     *
     * @param string $str The string to limit
     * @param int $limit Maximum number of characters
     * @param string|null $end_char String to append if the string is truncated
     * @param bool $preserve_words Whether to preserve whole words
     *
     * @return string The truncated string
     */
    public static function limitChars($str, $limit = 100, $end_char = null, $preserve_words = false): string
    {
        $end_char = (null === $end_char) ? '…' : $end_char;

        $limit = (int)$limit;

        if ('' === \trim($str) or \strlen($str) <= $limit) {
            return $str;
        }

        if ($limit <= 0) {
            return $end_char;
        }

        if (false === $preserve_words) {
            return \rtrim(\substr($str, 0, $limit)) . $end_char;
        }

        // Don't preserve words. The limit is considered the top limit.
        // No strings with a length longer than $limit should be returned.
        if (!\preg_match('/^.{0,' . $limit . '}\s/us', $str, $matches)) {
            return $end_char;
        }

        return \rtrim($matches[0]) . ((\strlen($matches[0]) === \strlen($str)) ? '' : $end_char);
    }

    /**
     * Generates an incremental ID with an optional prefix.
     *
     * @param string $prefix The prefix to use for the ID
     *
     * @return string The generated ID
     */
    public static function getIncrementalId($prefix = '__undefined__'): string
    {
        static $indexes = [];

        if (!\array_key_exists($prefix, $indexes)) {
            $indexes[$prefix] = -1;
        }

        ++$indexes[$prefix];

        return ('__undefined__' != $prefix ? $prefix : null) . $indexes[$prefix];
    }

    /**
     * Checks if a string is blank (empty or contains only whitespace).
     *
     * @param string $string The string to check
     *
     * @return bool True if the string is blank, false otherwise
     */
    public static function isBlank($string): bool
    {
        return !\strlen(\trim((string)$string)) > 0;
    }

    /**
     * Removes a string from the start of another string.
     *
     * @param string $string The string to process
     * @param string $stringToRemove The string to remove from the start
     * @param bool $caseSensitive Whether the comparison should be case-sensitive
     * @param string $encoding The character encoding to use
     *
     * @return string The processed string
     */
    public static function removeFromStart(string $string, string $stringToRemove, bool $caseSensitive = true, $encoding = 'UTF-8'): string
    {
        if (static::startsWith($string, $stringToRemove, $caseSensitive, $encoding)) {
            return \mb_substr($string, \mb_strlen($stringToRemove, $encoding), null, $encoding);
        }

        return $string;
    }

    /**
     * Removes a string from the end of another string.
     *
     * @param string $string The string to process
     * @param string $stringToRemove The string to remove from the end
     * @param bool $caseSensitive Whether the comparison should be case-sensitive
     * @param string $encoding The character encoding to use
     *
     * @return string The processed string
     */
    public static function removeFromEnd(string $string, string $stringToRemove, bool $caseSensitive = true, $encoding = 'UTF-8'): string
    {
        if (static::endsWith($string, $stringToRemove, $caseSensitive, $encoding)) {
            return \mb_substr($string, 0, -\mb_strlen($stringToRemove, $encoding), $encoding);
        }

        return $string;
    }

    /**
     * Converts a string with line breaks into an array of lines.
     *
     * @param string $string The string to convert
     *
     * @return array Array of lines
     */
    public static function linesToArray(string $string): array
    {
        $lines = \preg_split('/\r\n|\n|\r/', $string);

        return false !== $lines ? $lines : [];
    }

    /**
     * Translates a string with optional parameters.
     *
     * @param string $string The string to translate
     * @param array|null $params Parameters to replace in the string
     *
     * @return string The translated string
     */
    function __($string, array $params = null)
    {
        if (!empty($params)) {
            return $string;
        }

        return \strtr($string, $params);
    }
}
