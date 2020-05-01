<?php

namespace AndreasGlaser\Helpers\Http;

/**
 * Class RequestHelper.
 */
class RequestHelper
{
    /**
     * @return bool
     */
    public static function isCli()
    {
        return !isset($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return bool
     */
    public static function isHttps()
    {
        return isset($_SERVER['HTTPS']) && 'off' !== $_SERVER['HTTPS'];
    }
}
