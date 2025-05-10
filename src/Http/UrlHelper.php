<?php

namespace AndreasGlaser\Helpers\Http;

/**
 * UrlHelper provides utility methods for working with URLs and server environment.
 * 
 * This class contains methods for:
 * - Building protocol, host, and port strings
 * - Generating query strings
 * - Retrieving the current URL and URI
 */
class UrlHelper
{
    /**
     * Returns the protocol, server name, and port as a string based on server configuration.
     *
     * Examples:
     * - http://example.com
     * - http://example.com:8080 (if custom http port is used)
     * - https://example.com:444 (if custom https port is used)
     *
     * @return string|null The protocol, host, and port string, or null if running in CLI
     */
    public static function protocolHostPort()
    {
        if (RequestHelper::isCli()) {
            return null;
        }

        $isHttps = RequestHelper::isHttps();
        $protocol = 'http' . ($isHttps ? 's' : '');
        $serverName = $_SERVER['SERVER_NAME'];
        $serverPort = (int)$_SERVER['SERVER_PORT'];

        $protocolHostPort = $protocol . '://';

        if ((!$isHttps && 80 !== $serverPort) || ($isHttps && 443 !== $serverPort)) {
            $protocolHostPort .= $serverName . ':' . $serverPort;
        } else {
            $protocolHostPort .= $serverName;
        }

        return $protocolHostPort;
    }

    /**
     * Builds the query part of a URL from an array of parameters.
     *
     * @param array|null $parameters The parameters to include in the query string
     * @param bool $mergeGetVariables Whether to merge with current $_GET variables (default: true)
     *
     * @return string|null The query string (including '?'), or null if no parameters
     */
    public static function query(array $parameters = null, bool $mergeGetVariables = true)
    {
        if ($mergeGetVariables) {
            if (null === $parameters) {
                $parameters = $_GET;
            } else {
                $parameters = \array_replace_recursive($_GET, $parameters);
            }
        }

        if (empty($parameters)) {
            return null;
        }

        $query = \http_build_query($parameters, '', '&');

        return ('' === $query) ? '' : ('?' . $query);
    }

    /**
     * Returns the current full URL, optionally including the query string and URL-encoding.
     *
     * @param bool $includeQuery Whether to include the query string (default: true)
     * @param bool $urlEncode Whether to URL-encode the result (default: false)
     *
     * @return string|null The current URL, or null if running in CLI
     */
    public static function currentUrl(bool $includeQuery = true, bool $urlEncode = false)
    {
        if (RequestHelper::isCli()) {
            return null;
        }

        $url = static::protocolHostPort() . static::currentUri($includeQuery, $urlEncode);

        return $urlEncode ? \urlencode($url) : $url;
    }

    /**
     * Returns the current URI, optionally including query parameters and encoding.
     *
     * @param bool $includeQueryParams Whether to include query parameters (default: true)
     * @param bool $encode Whether to URL-encode the result (default: false)
     *
     * @return string|null The current URI, or null if running in CLI
     */
    public static function currentUri(bool $includeQueryParams = true, bool $encode = false)
    {
        if (RequestHelper::isCli()) {
            return null;
        }

        $uri = $_SERVER['REQUEST_URI'];

        if (!$includeQueryParams) {
            if ($separatorPosition = \strpos($uri, '?')) {
                $uri = \substr($uri, 0, $separatorPosition);
            }
        }

        return $encode ? \urlencode($uri) : $uri;
    }
}
