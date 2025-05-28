<?php

namespace AndreasGlaser\Helpers;

use Exception;

/**
 * ArrayHelper provides utility methods for array manipulation and access.
 * 
 * This class contains methods for working with arrays, including:
 * - Accessing and modifying array values using dot notation paths
 * - Array manipulation (prepend, append, insert, remove)
 * - Array transformation and validation
 * - Array merging and comparison
 */
class ArrayHelper
{
    /**
     * @var string The delimiter used for path notation in arrays
     */
    const PATH_DELIMITER = '.';

    /**
     * Returns value by key or a default value if it does not exist.
     *
     * @param array $array The array to search in
     * @param mixed $key The key to look for
     * @param mixed $default The default value to return if key doesn't exist
     *
     * @return mixed The value if found, default value otherwise
     */
    public static function get(array $array, $key, $default = null)
    {
        return \array_key_exists($key, $array) ? $array[$key] : $default;
    }

    /**
     * Returns first array key with matching value.
     *
     * @param array $array The array to search in
     * @param mixed $value The value to search for
     * @param mixed $default The default value to return if value not found
     * @param bool $strict Whether to use strict comparison
     *
     * @return mixed|null The key if found, default value otherwise
     */
    public static function getKeyByValue(array $array, $value, $default = null, $strict = true)
    {
        $key = \array_search($value, $array, $strict);

        return false !== $key ? $key : $default;
    }

    /**
     * Gets a value from an array using a dot-notation path.
     *
     * @param array $array The array to search in
     * @param string $path The dot-notation path to the value
     * @param bool $throwException Whether to throw an exception if path doesn't exist
     * @param mixed $default The default value to return if path doesn't exist
     * @param string $delimiter The path delimiter
     *
     * @return mixed The value if found, default value otherwise
     *
     * @throws \RuntimeException If path doesn't exist and $throwException is true
     */
    public static function getByPath(array $array, $path, $throwException = false, $default = null, $delimiter = self::PATH_DELIMITER)
    {
        $pieces = \explode($delimiter, $path);

        $value = $default;

        foreach ($pieces as $piece) {
            if (\array_key_exists($piece, $array)) {
                $value = $array[$piece];
                $array = $array[$piece];
            } else {
                if ($throwException) {
                    throw new \RuntimeException(\sprintf('Array index "%s" does not exist', $piece));
                } else {
                    return $default;
                }
            }
        }

        return $value;
    }

    /**
     * Sets a value in an array using a dot-notation path.
     *
     * @param array $array The array to modify
     * @param string $path The dot-notation path to set
     * @param mixed $value The value to set
     * @param string $delimiter The path delimiter
     *
     * @return array The modified array
     *
     * @throws \RuntimeException If path exists but is not an array
     */
    public static function setByPath(array $array, $path, $value, $delimiter = self::PATH_DELIMITER)
    {
        $current = &$array;
        $pathParts = \explode($delimiter, $path);
        $partCount = \count($pathParts);

        $i = 1;
        foreach ($pathParts as $piece) {
            $isLast = $i === $partCount;

            if (\array_key_exists($piece, $current)) {
                if ($isLast) {
                    $current[$piece] = $value;
                } else {
                    if (!\is_array($current[$piece])) {
                        throw new \RuntimeException(\sprintf('Array index "%s" exists already and is not of type "array"', $piece));
                    }
                }
            } else {
                $current[$piece] = $isLast ? $value : [];
            }

            $current = &$current[$piece];
            ++$i;
        }

        return $array;
    }

    /**
     * Removes a value from an array using a dot-notation path.
     *
     * @param array $array The array to modify
     * @param string $path The dot-notation path to remove
     * @param string $delimiter The path delimiter
     *
     * @return array The modified array
     */
    public static function unsetByPath(array $array, string $path, string $delimiter = self::PATH_DELIMITER): array
    {
        $current = &$array;
        $pathParts = \explode($delimiter, $path);
        $partCount = \count($pathParts);

        $i = 1;
        foreach ($pathParts as $piece) {
            $isLast = $i === $partCount;

            if (!\array_key_exists($piece, $current)) {
                break;
            }

            if ($isLast) {
                unset($current[$piece]);
                break;
            }

            $current = &$current[$piece];
            ++$i;
        }

        return $array;
    }

    /**
     * Checks if a path exists in an array using dot-notation.
     *
     * @param array $array The array to check
     * @param string $path The dot-notation path to check
     * @param string $delimiter The path delimiter
     *
     * @return bool True if the path exists
     */
    public static function existsByPath(array $array, $path, $delimiter = self::PATH_DELIMITER)
    {
        $current = &$array;
        $pathParts = \explode($delimiter, $path);

        foreach ($pathParts as $pathPart) {
            if (\is_array($current) && \array_key_exists($pathPart, $current)) {
                $current = $current[$pathPart];
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if a path is set in an array using dot-notation.
     *
     * @param array $array The array to check
     * @param string $path The dot-notation path to check
     * @param string $delimiter The path delimiter
     *
     * @return bool True if the path is set
     */
    public static function issetByPath(array $array, $path, $delimiter = self::PATH_DELIMITER)
    {
        $current = &$array;
        $pathParts = \explode($delimiter, $path);

        foreach ($pathParts as $pathPart) {
            if (\is_array($current) && isset($current[$pathPart])) {
                $current = $current[$pathPart];
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Adds an element at the beginning of an array.
     *
     * @param array $array The array to modify
     * @param mixed $value The value to add
     * @param mixed $key The key to use (optional)
     *
     * @return array The modified array
     */
    public static function prepend(array $array, $value, $key = false)
    {
        $array = \array_reverse($array, true);

        if (false !== $key) {
            $array[$key] = $value;
        } else {
            $array[] = $value;
        }

        return \array_reverse($array, true);
    }

    /**
     * Adds an element at the end of an array.
     *
     * @param array $array The array to modify
     * @param mixed $value The value to add
     * @param mixed $key The key to use (optional)
     *
     * @return array The modified array
     */
    public static function append(array $array, $value, $key = false)
    {
        if (false !== $key) {
            $array[$key] = $value;
        } else {
            $array[] = $value;
        }

        return $array;
    }

    /**
     * Inserts values before a specific position in an array.
     *
     * @param array $array The array to modify
     * @param mixed $position The position to insert before
     * @param array $values The values to insert
     *
     * @return array The modified array
     *
     * @throws Exception If the position doesn't exist
     */
    public static function insertBefore(array &$array, $position, array $values)
    {
        // enforce existing position
        if (!isset($array[$position])) {
            throw new Exception(\strtr('Array position does not exist (:1)', [':1' => $position]));
        }

        // offset
        $offset = -1;

        // loop through array
        foreach ($array as $key => $value) {
            // increase offset
            ++$offset;

            // break if key has been found
            if ($key == $position) {
                break;
            }
        }

        return \array_slice($array, 0, $offset, true) + $values + \array_slice($array, $offset, null, true);
    }

    /**
     * Inserts values after a specific position in an array.
     *
     * @param array $array The array to modify
     * @param mixed $position The position to insert after
     * @param array $values The values to insert
     *
     * @return array The modified array
     *
     * @throws Exception If the position doesn't exist
     */
    public static function insertAfter(array &$array, $position, array $values)
    {
        // enforce existing position
        if (!isset($array[$position])) {
            throw new Exception(\strtr('Array position does not exist (:1)', [':1' => $position]));
        }

        // offset
        $offset = 0;

        // loop through array
        foreach ($array as $key => $value) {
            // increase offset
            ++$offset;

            // break if key has been found
            if ($key == $position) {
                break;
            }
        }

        $array = \array_slice($array, 0, $offset, true) + $values + \array_slice($array, $offset, null, true);

        return $array;
    }

    /**
     * Gets the first value from an array.
     *
     * @param array $array The array to get value from
     * @param mixed $default The default value to return if array is empty
     *
     * @return mixed The first value or default
     */
    public static function getFirstValue(array $array, $default = null)
    {
        $firstItem = \reset($array);

        return $firstItem ? $firstItem : $default;
    }

    /**
     * Gets the last value from an array.
     *
     * @param array $array The array to get value from
     * @param mixed $default The default value to return if array is empty
     *
     * @return mixed The last value or default
     */
    public static function getLastValue(array $array, $default = null)
    {
        $lastItem = \end($array);

        return $lastItem ? $lastItem : $default;
    }

    /**
     * Gets a random value from an array.
     *
     * @param array $array The array to get value from
     *
     * @return mixed A random value from the array
     */
    public static function getRandomValue(array $array)
    {
        return $array[\array_rand($array)];
    }

    /**
     * Removes the first element from an array.
     *
     * @param array $array The array to modify
     *
     * @return array The modified array
     */
    public static function removeFirstElement(array $array): array
    {
        if (true === empty($array)) {
            return $array;
        }

        \reset($array);
        unset($array[\key($array)]);

        return $array;
    }

    /**
     * Removes the last element from an array.
     *
     * @param array $array The array to modify
     *
     * @return array The modified array
     */
    public static function removeLastElement(array $array): array
    {
        \array_pop($array);

        return $array;
    }

    /**
     * Removes elements with a specific value from an array.
     *
     * @param array $array The array to modify
     * @param mixed $value The value to remove
     * @param bool $strict Whether to use strict comparison
     *
     * @return array The modified array
     */
    public static function removeByValue(array $array, $value, $strict = true)
    {
        $key = \array_search($value, $array, $strict);
        if (false !== $key) {
            unset($array[$key]);
        }

        return $array;
    }

    /**
     * Converts array keys from camelCase to underscore_case.
     *
     * @param array $array The array to modify
     *
     * @return array The modified array
     */
    public static function keysCamelToUnderscore(array $array)
    {
        $newArray = [];

        foreach ($array as $key => $value) {
            if (!\is_array($value)) {
                unset($array[$key]);
                $newArray[StringHelper::camelToUnderscore($key)] = $value;
            } else {
                unset($array[$key]);
                $newArray[StringHelper::camelToUnderscore($key)] = self::keysCamelToUnderscore($value);
            }
        }

        return $newArray;
    }

    /**
     * Removes empty values from an array.
     *
     * @param array $array The array to modify
     * @param bool $recursive Whether to process nested arrays
     *
     * @return array The modified array
     */
    public static function unsetEmptyValues(array $array, $recursive = false)
    {
        foreach ($array as $key => $value) {
            if (empty($value)) {
                unset($array[$key]);
                continue;
            }

            if (true === $recursive && \is_array($value)) {
                $array[$key] = self::unsetEmptyValues($value);
            }
        }

        return $array;
    }

    /**
     * Joins array elements with a string, ignoring empty values.
     *
     * @param string $glue The string to join with
     * @param array $pieces The array to join
     *
     * @return string The joined string
     */
    public static function implodeIgnoreEmpty($glue, array $pieces)
    {
        $processedPieces = [];
        foreach ($pieces as $piece) {
            if (!empty($piece)) {
                $processedPieces[] = $piece;
            }
        }

        return \implode($glue, $processedPieces);
    }

    /**
     * Joins array keys with a string.
     *
     * @param string $glue The string to join with
     * @param array $array The array whose keys to join
     *
     * @return string The joined string
     */
    public static function implodeKeys($glue, array $array)
    {
        return \implode($glue, \array_keys($array));
    }

    /**
     * Splits a string into an array, ignoring empty values.
     *
     * @param string $delimiter The boundary string
     * @param string $string The input string
     *
     * @return array The resulting array
     */
    public static function explodeIgnoreEmpty($delimiter, $string)
    {
        $return = [];
        $pieces = \explode($delimiter, $string);
        foreach ($pieces as $value) {
            if (!empty($value)) {
                $return[] = $value;
            }
        }

        return $return;
    }

    /**
     * Converts array values to uppercase.
     *
     * @param array $array The array to modify
     * @param bool $recursive Whether to process nested arrays
     *
     * @return array The modified array
     */
    public static function valueToUpper(array $array, $recursive = true)
    {
        $return = [];

        foreach ($array as $key => $value) {
            if ($recursive && \is_array($value)) {
                $return[$key] = self::valueToUpper($value, $recursive);
            }

            $return[$key] = \mb_strtoupper($value);
        }

        return $return;
    }

    /**
     * Checks if an array is associative.
     *
     * @param array $array The array to check
     *
     * @return bool True if the array is associative
     */
    public static function isAssoc(array $array)
    {
        $keys = \array_keys($array);

        return \array_keys($keys) !== $keys;
    }

    /**
     * Checks if all keys from one array exist in another array.
     *
     * @param array $arrayToCheck The array to check
     * @param array $arrayToCompareWith The array to compare against
     * @param bool $throwException Whether to throw an exception if keys are missing
     *
     * @return bool True if all keys exist
     *
     * @throws \RuntimeException If keys are missing and $throwException is true
     */
    public static function assocIndexesExist(array $arrayToCheck, array $arrayToCompareWith, $throwException = true)
    {
        $exists = true;

        foreach ($arrayToCheck as $key => $value) {
            if (self::isAssoc($arrayToCompareWith)) {
                if (!\array_key_exists($key, $arrayToCompareWith)) {
                    if ($throwException) {
                        throw new \RuntimeException('Key does not exist (' . $key . ')');
                    } else {
                        $exists = false;
                    }
                } elseif (\is_array($value)) {
                    if (!$exists = self::assocIndexesExist($value, $arrayToCompareWith[$key], $throwException)) {
                        return false;
                    }
                }
            }
        }

        return $exists;
    }

    /**
     * Replaces a value in an array with another value.
     *
     * @param array $array The array to modify
     * @param mixed $value The value to replace
     * @param mixed $replacement The replacement value
     * @param bool $recursively Whether to process nested arrays
     * @param bool $caseSensitive Whether to use case-sensitive comparison
     *
     * @return array The modified array
     */
    public static function replaceValue(array $array, $value, $replacement, $recursively = true, $caseSensitive = true)
    {
        foreach ($array as $k => $v) {
            if ($recursively && \is_array($v)) {
                $array[$k] = self::replaceValue($array[$k], $value, $replacement, $recursively, $caseSensitive);
            } elseif (\is_string($v) && StringHelper::is($v, $value, $caseSensitive)) {
                $array[$k] = $replacement;
            }
        }

        return $array;
    }

    /**
     * Merges multiple arrays recursively.
     *
     * @param array ...$arrays The arrays to merge
     *
     * @return array The merged array
     */
    public static function merge()
    {
        $arrays = \func_get_args();

        $result = [];

        foreach ($arrays as $argumentIndex => $array) {
            if (!\is_array($array)) {
                throw new \InvalidArgumentException(\sprintf('Argument %d is not an array', $argumentIndex + 1));
            }

            foreach ($array as $key => $value) {
                if (\is_integer($key)) {
                    $result[] = $value;
                } elseif (isset($result[$key]) && \is_array($result[$key]) && \is_array($value)) {
                    $result[$key] = static::merge($result[$key], $value);
                } else {
                    $result[$key] = $value;
                }
            }
        }

        return $result;
    }

    /**
     * Gets the first index of an array.
     *
     * @param array $array The array to check
     * @param mixed $default The default value to return if array is empty
     *
     * @return mixed The first index or default
     */
    public static function getFirstIndex($array, $default = null)
    {
        return static::getFirstValue($array, $default);
    }

    /**
     * Adds an element at the beginning of an array with a specific key.
     *
     * @param array $array The array to modify
     * @param mixed $key The key to use
     * @param mixed $val The value to add
     *
     * @return array The modified array
     */
    public static function unshiftAssoc($array, $key, $val)
    {
        return static::prepend($array, $val, $key);
    }

    /**
     * Removes the first index from an array.
     *
     * @param array $array The array to modify
     *
     * @return array The modified array
     */
    public static function removeFirstIndex(array $array)
    {
        return self::removeFirstElement($array);
    }
}
