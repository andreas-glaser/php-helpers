<?php

namespace AndreasGlaser\Helpers;

use Exception;

class ArrayHelper
{
    public const PATH_DELIMITER = '.';

    /**
     * Returns value by key or a default value if it does not exist.
     */
    public static function get(array $array, string $key, $default = null)
    {
        return \array_key_exists($key, $array) ? $array[$key] : $default;
    }

    /**
     * Returns first array key with matching value.
     */
    public static function getKeyByValue(array $array, $value, $default = null, bool $strict = true)
    {
        $key = array_search($value, $array, $strict);

        return false !== $key ? $key : $default;
    }

    /**
     * Simplifies access to nested array values. e.g.:.
     *
     * $myArray = [
     *      'someIndex' => 'some value',
     *      'nestedArray' => [
     *          'someIndex' => 'xyz',
     *          'nestedArray' => [
     *              'someIndex' => 'some value',
     *          ]
     *      ]
     * ];
     *
     * ArrayHelper::getByPath($myArray, 'someIndex'); // some value
     * ArrayHelper::getByPath($myArray, 'someIndex.nestedArray'); // nested Array
     * ArrayHelper::getByPath($myArray, 'someIndex.nestedArray.someIndex'); // xyz
     */
    public static function getByPath(array $array, string $path, bool $throwException = false, $default = null, string $delimiter = self::PATH_DELIMITER)
    {
        $pieces = explode($delimiter, $path);

        $value = $default;

        foreach ($pieces as $piece) {
            if (true === \array_key_exists($piece, $array)) {
                $value = $array[$piece];
                $array = $array[$piece];
            } else {
                if ($throwException) {
                    throw new \RuntimeException(sprintf('Array index "%s" does not exist', $piece));
                } else {
                    return $default;
                }
            }
        }

        return $value;
    }

    public static function setByPath(array $array, string $path, $value, string $delimiter = self::PATH_DELIMITER): array
    {
        $current = &$array;
        $pathParts = explode($delimiter, $path);
        $partCount = \count($pathParts);

        $i = 1;
        foreach ($pathParts as $piece) {
            $isLast = $i === $partCount;

            if (true === \array_key_exists($piece, $current)) {
                if ($isLast) {
                    $current[$piece] = $value;
                } else {
                    if (false === \is_array($current[$piece])) {
                        throw new \RuntimeException(sprintf('Array index "%s" exists already and is not of type "array"', $piece));
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

    public static function unsetByPath(array $array, string $path, string $delimiter = self::PATH_DELIMITER): array
    {
        $current = &$array;
        $pathParts = explode($delimiter, $path);
        $partCount = \count($pathParts);

        $i = 1;
        foreach ($pathParts as $piece) {
            $isLast = $i === $partCount;

            if (false === \array_key_exists($piece, $current)) {
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

    public static function existsByPath(array $array, string $path, string $delimiter = self::PATH_DELIMITER): bool
    {
        $current = &$array;
        $pathParts = explode($delimiter, $path);

        foreach ($pathParts as $pathPart) {
            if (true === \is_array($current) && \array_key_exists($pathPart, $current)) {
                $current = $current[$pathPart];
            } else {
                return false;
            }
        }

        return true;
    }

    public static function issetByPath(array $array, string $path, string $delimiter = self::PATH_DELIMITER): bool
    {
        $current = &$array;
        $pathParts = explode($delimiter, $path);

        foreach ($pathParts as $pathPart) {
            if (true === \is_array($current) && isset($current[$pathPart])) {
                $current = $current[$pathPart];
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Adds index/value at the beginning of an array.
     *
     * @param string|int|null $key
     */
    public static function prepend(array $array, $value, $key = null): array
    {
        $array = array_reverse($array, true);

        if (null !== $key) {
            $array[$key] = $value;
        } else {
            $array[] = $value;
        }

        return array_reverse($array, true);
    }

    /**
     * Adds index/value at the end of an array.
     *
     * @param string|int|null $key
     */
    public static function append(array $array, $value, $key = null): array
    {
        if (null !== $key) {
            $array[$key] = $value;
        } else {
            $array[] = $value;
        }

        return $array;
    }

    /**
     * @param string|int $position
     *
     * @throws Exception
     */
    public static function insertBefore(array $array, $position, array $values): array
    {
        // enforce existing position
        if (!isset($array[$position])) {
            throw new Exception(strtr('Array position does not exist (:1)', [':1' => $position]));
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
     * @param string|int $position
     *
     * @throws Exception
     */
    public static function insertAfter(array $array, $position, array $values): array
    {
        // enforce existing position
        if (!isset($array[$position])) {
            throw new Exception(strtr('Array position does not exist (:1)', [':1' => $position]));
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

        return \array_slice($array, 0, $offset, true) + $values + \array_slice($array, $offset, null, true);
    }

    /**
     * Returns the value of the first index of an array.
     */
    public static function getFirstValue(array $array, $default = null)
    {
        $firstItem = reset($array);

        return $firstItem ? $firstItem : $default;
    }

    /**
     * Returns the value of the last index of an array.
     */
    public static function getLastValue(array $array, $default = null)
    {
        $lastItem = end($array);

        return $lastItem ? $lastItem : $default;
    }

    /**
     * Returns random value of array.
     */
    public static function getRandomValue(array $array)
    {
        return $array[array_rand($array)];
    }

    /**
     * Removes first element of an array without re-indexing.
     */
    public static function removeFirstElement(array $array): array
    {
        if (true === empty($array)) {
            return $array;
        }

        reset($array);
        unset($array[key($array)]);

        return $array;
    }

    /**
     * Removes first element of an array without re-indexing.
     */
    public static function removeLastElement(array $array): array
    {
        array_pop($array);

        return $array;
    }

    /**
     * Removes array item by value.
     */
    public static function removeByValue(array $array, $value, bool $strict = true): array
    {
        $key = array_search($value, $array, $strict);
        if (false !== $key) {
            unset($array[$key]);
        }

        return $array;
    }

    /**
     * Recursively converts array keys from camel case to underscore case.
     */
    public static function keysCamelToUnderscore(array $array): array
    {
        $newArray = [];

        foreach ($array as $key => $value) {
            if (false === \is_array($value)) {
                unset($array[$key]);
                $newArray[StringHelper::camelToUnderscore($key)] = $value;
            } else {
                unset($array[$key]);
                $newArray[StringHelper::camelToUnderscore($key)] = self::keysCamelToUnderscore($value);
            }
        }

        return $newArray;
    }

    public static function unsetEmptyValues(array $array, bool $recursive = false): array
    {
        foreach ($array as $key => $value) {
            if (true === empty($value)) {
                unset($array[$key]);
                continue;
            }

            if (true === $recursive && \is_array($value)) {
                $array[$key] = self::unsetEmptyValues($value);
            }
        }

        return $array;
    }

    public static function implodeIgnoreEmpty(string $glue, array $pieces): string
    {
        $processedPieces = [];
        foreach ($pieces as $piece) {
            if (false === empty($piece)) {
                $processedPieces[] = $piece;
            }
        }

        return implode($glue, $processedPieces);
    }

    public static function implodeIgnoreBlank(string $glue, array $pieces): string
    {
        $processedPieces = [];
        foreach ($pieces as $piece) {
            if (false === StringHelper::isBlank($piece)) {
                $processedPieces[] = $piece;
            }
        }

        return implode($glue, $processedPieces);
    }

    /**
     * Implodes array keys.
     */
    public static function implodeKeys(string $glue, array $array): string
    {
        return implode($glue, array_keys($array));
    }

    public static function explodeIgnoreEmpty(string $delimiter, string $string): array
    {
        $return = [];
        $pieces = explode($delimiter, $string);
        foreach ($pieces as $value) {
            if (!empty($value)) {
                $return[] = $value;
            }
        }

        return $return;
    }

    public static function valueToUpper(array $array, bool $recursive = true): array
    {
        $return = [];

        foreach ($array as $key => $value) {
            if (true === $recursive && true === \is_array($value)) {
                $return[$key] = self::valueToUpper($value, $recursive);
            } else {
                $return[$key] = mb_strtoupper($value);
            }
        }

        return $return;
    }

    /**
     * Checks if given array is associative.
     */
    public static function isAssoc(array $array): bool
    {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    }

    /**
     * Checks if associative indexes in array1 existing in array2.
     * This is useful for the validation of configuration arrays.
     */
    public static function assocIndexesExist(array $arrayToCheck, array $arrayToCompareWith, bool $throwException = true): bool
    {
        $exists = true;

        foreach ($arrayToCheck as $key => $value) {
            if (self::isAssoc($arrayToCompareWith)) {
                if (false === \array_key_exists($key, $arrayToCompareWith)) {
                    if ($throwException) {
                        throw new \RuntimeException('Key does not exist (' . $key . ')');
                    } else {
                        $exists = false;
                    }
                } elseif (true === \is_array($value)) {
                    if (!$exists = self::assocIndexesExist($value, $arrayToCompareWith[$key], $throwException)) {
                        return false;
                    }
                }
            }
        }

        return $exists;
    }

    /**
     * Replaces values of an array.
     */
    public static function replaceValue(array $array, $value, $replacement, bool $recursively = true, bool $caseSensitive = true): array
    {
        foreach ($array as $k => $v) {
            if ($recursively && \is_array($v)) {
                $array[$k] = self::replaceValue($v, $value, $replacement, $recursively, $caseSensitive);
            } elseif (true === \is_string($v) && StringHelper::is($v, $value, $caseSensitive)) {
                $array[$k] = $replacement;
            }
        }

        return $array;
    }

    /**
     * Merges multiple arrays.
     *
     * @source https://api.drupal.org/api/drupal/includes!bootstrap.inc/function/drupal_array_merge_deep_array/7
     */
    public static function merge(): array
    {
        $arrays = \func_get_args();

        $result = [];

        foreach ($arrays as $argumentIndex => $array) {
            if (false === \is_array($array)) {
                throw new \InvalidArgumentException(sprintf('Argument %d is not an array', $argumentIndex + 1));
            }

            foreach ($array as $key => $value) {
                if (true === \is_integer($key)) {
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
}
