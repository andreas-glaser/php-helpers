<?php

namespace AndreasGlaser\Helpers;

use \Exception;

/**
 * Class ArrayHelper
 *
 * @package Helpers
 *
 * @author  Andreas Glaser
 */
class ArrayHelper
{

    /**
     * @param array $array
     * @param       $position
     * @param array $values
     *
     * @return array
     * @throws Exception
     */
    public static function insertBefore(array &$array, $position, array $values)
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

        return array_slice($array, 0, $offset, true) + $values + array_slice($array, $offset, null, true);
    }

    /**
     * @param array $array
     * @param       $position
     * @param array $values
     *
     * @return array
     * @throws Exception
     */
    public static function insertAfter(array &$array, $position, array $values)
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

        $array = array_slice($array, 0, $offset, true) + $values + array_slice($array, $offset, null, true);

        return $array;
    }

    /**
     * @param array $array
     * @param null  $default
     *
     * @return mixed|null
     *
     * @author Andreas Glaser
     */
    public static function getFirstIndex($array, $default = null)
    {
        if (!is_array($array)) {
            return $default;
        }

        $firstItem = reset($array);

        return $firstItem ? $firstItem : $default;
    }

    /**
     * Removes first element of an array without re-indexing.
     *
     * @param array $array
     *
     * @return array
     *
     * @author Andreas Glaser
     */
    public static function removeFirstIndex(array $array)
    {
        if (empty($array)) {
            return $array;
        }

        reset($array);
        unset($array[key($array)]);

        return $array;
    }

    /**
     * Recursively converts array keys from camel case to underscore case.
     *
     * @param array $array
     *
     * @return array
     *
     * @author Andreas Glaser
     */
    public static function keysCamelToUnderscore(array $array)
    {
        $newArray = [];

        foreach ($array AS $key => $value) {

            if (!is_array($value)) {
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
     * @param array $array
     * @param bool  $recursive
     *
     * @return array
     *
     * @author Andreas Glaser
     */
    public static function unsetEmptyValues(array $array, $recursive = false)
    {
        foreach ($array AS $key => $value) {
            if (empty($value)) {
                unset($array[$key]);
                continue;
            }

            if ($recursive === true && is_array($value)) {
                $array[$key] = self::unsetEmptyValues($value);
            }
        }

        return $array;
    }

    /**
     * @param       $glue
     * @param array $pieces
     *
     * @return string
     *
     * @author Andreas Glaser
     */
    public static function implodeIgnoreEmpty($glue, array $pieces)
    {
        $processedPieces = [];
        foreach ($pieces AS $piece) {
            if (!empty($piece)) {
                $processedPieces[] = $piece;
            }
        }

        return implode($glue, $processedPieces);
    }

    /**
     * @param array $array
     * @param bool  $recursive
     *
     * @return array
     *
     * @author Andreas Glaser
     */
    public static function valueToUpper(array $array, $recursive = true)
    {
        $return = [];

        foreach ($array AS $key => $value) {
            if ($recursive && is_array($value)) {
                $return[$key] = self::valueToUpper($value, $recursive);
            }

            $return[$key] = mb_strtoupper($value);
        }

        return $return;
    }

    /**
     * Checks if given array is associative.
     *
     * @param array $array
     *
     * @return bool
     *
     * @author Andreas Glaser
     */
    public static function isAssoc(array $array)
    {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    }

    /**
     * Checks if associative indexes in array1 existing in array2.
     * This is useful for the validation of configuration arrays.
     *
     * @param array $arrayToCheck
     * @param array $arrayToCompareWith
     * @param bool  $throwException
     *
     * @return bool
     *
     * @author Andreas Glaser
     */
    public static function assocIndexesExist(array $arrayToCheck, array $arrayToCompareWith, $throwException = true)
    {
        foreach ($arrayToCheck AS $key => $value) {
            if (self::isAssoc($arrayToCompareWith) && !array_key_exists($key, $arrayToCompareWith)) {
                if ($throwException) {
                    throw new \RuntimeException('Key does not exist (' . $key . ')');
                } else {
                    return false;
                }
            }

            if (is_array($value)) {
                if (!is_array($arrayToCompareWith[$key])) {
                    if ($throwException) {
                        throw new \RuntimeException('Value types do not match');
                    } else {
                        return false;
                    }
                }

                self::assocIndexesExist($value, $arrayToCompareWith[$key], $throwException);
            }
        }

        return true;
    }

    /**
     * @param $array
     * @param $key
     * @param $val
     *
     * @return array
     *
     * @author Andreas Glaser
     */
    public static function unshiftAssoc($array, $key, $val)
    {
        $array = array_reverse($array, true);
        $array[$key] = $val;

        return array_reverse($array, true);
    }
}

