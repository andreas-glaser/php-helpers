<?php

namespace AndreasGlaser\Helpers\Http;

/**
 * Class RequestHelper
 *
 * @package AndreasGlaser\Helpers\Http
 * @author  Andreas Glaser
 */
class RequestHelper
{
    /**
     * @return bool
     * @author Andreas Glaser
     */
    public static function isCli()
    {
        return !isset($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return bool
     * @author Andreas Glaser
     */
    public static function isHttps()
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    }
}


