<?php

namespace AndreasGlaser\Helpers\Http;

/**
 * Class UrlHelper
 *
 * @package AndreasGlaser\Helpers\Http
 */
class UrlHelper
{

    /**
     * Returns string of protocol, server name and port of server-side configured values.
     * e.g.:
     * http://example.com
     * http://example.com:8080 (if custom http port is used)
     * https://example.com:444 (if custom https port is used)
     *
     * @return null|string
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

        if ((!$isHttps && $serverPort !== 80) || ($isHttps && $serverPort !== 443)) {
            $protocolHostPort .= $serverName . ':' . $serverPort;
        } else {
            $protocolHostPort .= $serverName;
        }

        return $protocolHostPort;
    }

    /**
     * Builds query part of url.
     *
     * @param array $parameters
     * @param bool  $mergeGetVariables
     *
     * @return null|string
     */
    public static function query(array $parameters = null, bool $mergeGetVariables = true)
    {
        if ($mergeGetVariables) {
            if ($parameters === null) {
                $parameters = $_GET;
            } else {
                $parameters = array_replace_recursive($_GET, $parameters);
            }
        }

        if (empty($parameters)) {
            return null;
        }

        $query = http_build_query($parameters, '', '&');

        return ($query === '') ? '' : ('?' . $query);
    }

    /**
     * @param bool $includeQuery
     * @param bool $urlEncode
     *
     * @return null|string
     */
    public static function currentUrl(bool $includeQuery = true, bool $urlEncode = false)
    {
        if (RequestHelper::isCli()) {
            return null;
        }

        $url = static::protocolHostPort() . static::currentUri($includeQuery, $urlEncode);

        return $urlEncode ? urlencode($url) : $url;
    }

    /**
     * @param bool $includeQueryParams
     * @param bool $encode
     *
     * @return null|string
     */
    public static function currentUri(bool $includeQueryParams = true, bool $encode = false)
    {
        if (RequestHelper::isCli()) {
            return null;
        }

        $uri = $_SERVER['REQUEST_URI'];

        if (!$includeQueryParams) {
            if ($separatorPosition = strpos($uri, '?')) {
                $uri = substr($uri, 0, $separatorPosition);
            }
        }

        return $encode ? urlencode($uri) : $uri;
    }
}