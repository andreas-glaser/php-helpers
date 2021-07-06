<?php

namespace AndreasGlaser\Helpers\Http;

class RequestHelper
{
    public static function isCli(): bool
    {
        return !isset($_SERVER['REQUEST_METHOD']);
    }

    public static function isHttps(): bool
    {
        return isset($_SERVER['HTTPS']) && 'off' !== $_SERVER['HTTPS'];
    }
}
