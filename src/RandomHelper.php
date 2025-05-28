<?php

namespace AndreasGlaser\Helpers;

/**
 * RandomHelper provides utility methods for generating random values.
 * 
 * This class contains methods for:
 * - Generating random boolean values
 * - Creating cryptographically secure unique identifiers
 */
class RandomHelper
{
    /**
     * Generates a random boolean value.
     * 
     * This method uses PHP's rand() function to generate either true or false
     * with equal probability (50% chance each).
     *
     * @return bool A random boolean value
     */
    public static function trueFalse(): bool
    {
        return 1 === \rand(0, 1);
    }

    /**
     * Generates a cryptographically secure unique identifier.
     * 
     * This method:
     * - Uses random_bytes() if available (PHP 7+)
     * - Falls back to openssl_random_pseudo_bytes() if available
     * - Throws an exception if no secure random function is available
     * - Returns a 13-character hex string (optionally prefixed)
     *
     * @param string $prefix Optional prefix to prepend to the unique identifier
     *
     * @return string A cryptographically secure unique identifier
     *
     * @throws \Exception If no cryptographically secure random function is available
     * 
     * @source https://www.php.net/manual/en/function.uniqid.php#120123
     */
    public static function uniqid(string $prefix = ''): string
    {
        if (true === \function_exists('random_bytes')) {
            $bytes = \random_bytes(7);
        } elseif (true === \function_exists('openssl_random_pseudo_bytes')) {
            $bytes = \openssl_random_pseudo_bytes(7);
        } else {
            throw new \Exception('No cryptographically secure random function available');
        }

        return $prefix . \mb_substr(\bin2hex($bytes), 0, 13);
    }
}
