<?php

namespace AndreasGlaser\Helpers;

/**
 * Class RandomHelper.
 */
class RandomHelper
{
    /**
     * @return bool
     */
    public static function trueFalse()
    {
        return 1 === \rand(0, 1);
    }

    /**
     * @throws \Exception
     * @source @source https://www.php.net/manual/en/function.uniqid.php#120123
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
