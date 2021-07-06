<?php

namespace AndreasGlaser\Helpers;

class StringHelper
{
    public static function is(string $string, string $stringToMach, bool $caseSensitive = true): bool
    {
        if (false === $caseSensitive) {
            return 0 === strcasecmp($string, $stringToMach);
        }

        return 0 === strcmp($string, $stringToMach);
    }

    public static function isOneOf(string $string, array $stingsToCompare, bool $caseSensitive = true): bool
    {
        foreach ($stingsToCompare as $compareTo) {
            if (self::is($string, $compareTo, $caseSensitive)) {
                return true;
            }
        }

        return false;
    }

    public static function contains(string $haystack, string $needle, bool $caseSensitive = true, string $encoding = 'UTF-8'): bool
    {
        if (false === $caseSensitive) {
            return false !== mb_stristr($haystack, $needle, null, $encoding);
        }

        return false !== mb_strstr($haystack, $needle, null, $encoding);
    }

    public static function startsWith(string $haystack, string $needle, bool $caseSensitive = true, string $encoding = 'UTF-8'): bool
    {
        if (false === $caseSensitive) {
            return 0 === strncasecmp($haystack, $needle, mb_strlen($needle, $encoding));
        }

        return 0 === strncmp($haystack, $needle, mb_strlen($needle, $encoding));
    }

    public static function endsWith(string $haystack, string $needle, bool $caseSensitive = true, $encoding = 'UTF-8'): bool
    {
        // get length of needle
        $length = mb_strlen($needle, $encoding);

        // always return true if needle is empty
        if (0 === $length) {
            return true;
        }

        if (false === $caseSensitive) {
            return 0 === strcasecmp(mb_substr($haystack, -$length, null, $encoding), $needle);
        }

        return 0 === strcmp(mb_substr($haystack, -$length, null, $encoding), $needle);
    }

    public static function trimMulti(string $string, array $chars): string
    {
        foreach ($chars as $char) {
            $string = trim($string, $char);
        }

        return $string;
    }

    public static function lTrimMulti(string $string, array $chars): string
    {
        foreach ($chars as $char) {
            $string = ltrim($string, $char);
        }

        return $string;
    }

    public static function rTrimMulti(string $string, array $chars): string
    {
        foreach ($chars as $char) {
            $string = rtrim($string, $char);
        }

        return $string;
    }

    public static function camelToUnderscore(string $string): string
    {
        if (true === is_numeric($string)) {
            return $string;
        }

        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $ret);
    }

    public static function removeLineBreaks(string $string, string $replaceWith = ' '): ?string
    {
        return preg_replace('/[\r\n]+/', $replaceWith, $string);
    }

    public static function removeRedundantWhiteSpaces($string): ?string
    {
        return preg_replace('/\s+/', ' ', $string);
    }

    public static function replaceWhiteSpacesWithUnderscores($string): string
    {
        return str_replace(' ', '_', $string);
    }

    public static function machineReadable(string $string): string
    {
        return trim(self::replaceWhiteSpacesWithUnderscores(strtolower(self::removeRedundantWhiteSpaces(self::removeLineBreaks($string)))));
    }

    public static function append(string $string, string $stringToAppend): string
    {
        return $string . $stringToAppend;
    }

    public static function prepend(string $string, string $stringToPrepend): string
    {
        return $stringToPrepend . $string;
    }

    public static function removeChar(string $string, string $char): string
    {
        return str_replace($char, null, $string);
    }

    public static function removeChars(string $string, array $chars): string
    {
        foreach ($chars as $char) {
            $string = self::removeChar($string, $char);
        }

        return $string;
    }

    public static function explodeAndTrim(string $delimiter, string $string): array
    {
        $return = [];
        $pieces = explode($delimiter, $string);

        foreach ($pieces as $piece) {
            $return[] = trim($piece);
        }

        return $return;
    }

    /**
     * Replaces multiple parts of a string.
     */
    public static function replace(string $subject, array $replacementMap,bool $caseSensitive = true):string
    {
        foreach ($replacementMap as $search => $replace) {
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
     *     $text = static::limit_words($text);.
     *
     * @param string $str      phrase to limit words of
     * @param int    $limit    number of words to limit to
     * @param string $end_char end character or entity
     *
     * @return string
     */
    public static function limitWords($str, $limit = 100, $end_char = null)
    {
        $limit = (int)$limit;
        $end_char = (null === $end_char) ? '…' : $end_char;

        if ('' === trim($str)) {
            return $str;
        }

        if ($limit <= 0) {
            return $end_char;
        }

        preg_match('/^\s*+(?:\S++\s*+){1,' . $limit . '}/u', $str, $matches);

        // Only attach the end character if the matched string is shorter
        // than the starting string.
        return rtrim($matches[0]) . ((\strlen($matches[0]) === \strlen($str)) ? '' : $end_char);
    }

    /**
     * Limits a phrase to a given number of characters.
     *     $text = static::limit_chars($text);.
     *
     * @param string $str            phrase to limit characters of
     * @param int    $limit          number of characters to limit to
     * @param string $end_char       end character or entity
     * @param bool   $preserve_words enable or disable the preservation of words while limiting
     *
     * @return string
     *
     * @uses    strlen
     */
    public static function limitChars($str, $limit = 100, $end_char = null, $preserve_words = false)
    {
        $end_char = (null === $end_char) ? '…' : $end_char;

        $limit = (int)$limit;

        if ('' === trim($str) or \strlen($str) <= $limit) {
            return $str;
        }

        if ($limit <= 0) {
            return $end_char;
        }

        if (false === $preserve_words) {
            return rtrim(substr($str, 0, $limit)) . $end_char;
        }

        // Don't preserve words. The limit is considered the top limit.
        // No strings with a length longer than $limit should be returned.
        if (false === preg_match('/^.{0,' . $limit . '}\s/us', $str, $matches)) {
            return $end_char;
        }

        return rtrim($matches[0]) . ((\strlen($matches[0]) === \strlen($str)) ? '' : $end_char);
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public static function getIncrementalId($prefix = '__undefined__')
    {
        static $indexes = [];

        if (false === \array_key_exists($prefix, $indexes)) {
            $indexes[$prefix] = -1;
        }

        ++$indexes[$prefix];

        return ('__undefined__' != $prefix ? $prefix : null) . $indexes[$prefix];
    }

    /**
     * Checks if a string is blank. " " is considered as such.
     *
     * @param $string
     *
     * @return bool
     */
    public static function isBlank($string)
    {
        return !\strlen(trim((string)$string)) > 0;
    }

    /**
     * @param string $encoding
     */
    public static function removeFromStart(string $string, string $stringToRemove, bool $caseSensitive = true, $encoding = 'UTF-8'): string
    {
        if (static::startsWith($string, $stringToRemove, $caseSensitive, $encoding)) {
            return mb_substr($string, mb_strlen($stringToRemove, $encoding), null, $encoding);
        }

        return $string;
    }

    /**
     * @param string $encoding
     */
    public static function removeFromEnd(string $string, string $stringToRemove, bool $caseSensitive = true, $encoding = 'UTF-8'): string
    {
        if (static::endsWith($string, $stringToRemove, $caseSensitive, $encoding)) {
            return mb_substr($string, 0, -mb_strlen($stringToRemove, $encoding), $encoding);
        }

        return $string;
    }

    public static function linesToArray(string $string): array
    {
        $lines = preg_split('/\r\n|\n|\r/', $string);

        return false !== $lines ? $lines : [];
    }
}

// shortcut for strtr
if (false === \function_exists('__')) {
    function __($string, array $params = null)
    {
        if (!empty($params)) {
            return $string;
        }

        return strtr($string, $params);
    }
}
