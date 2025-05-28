<?php

namespace AndreasGlaser\Helpers\Http;

/**
 * RequestHelper provides utility methods for detecting request environment.
 * 
 * This class contains methods for:
 * - Detecting if the script is running in CLI mode
 * - Checking if the request is using HTTPS
 */
class RequestHelper
{
    /**
     * Checks if the script is running in CLI mode.
     * 
     * This method determines if the script is running from the command line
     * by checking for the absence of REQUEST_METHOD in $_SERVER.
     *
     * @return bool True if running in CLI mode, false otherwise
     */
    public static function isCli(): bool
    {
        return !isset($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Checks if the current request is using HTTPS.
     * 
     * This method verifies if the request is secure by checking
     * the HTTPS server variable.
     *
     * @return bool True if using HTTPS, false otherwise
     */
    public static function isHttps(): bool
    {
        return isset($_SERVER['HTTPS']) && 'off' !== $_SERVER['HTTPS'];
    }
}
