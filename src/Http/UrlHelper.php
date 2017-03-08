<?php

namespace AndreasGlaser\Helpers\Http;

use AndreasGlaser\Helpers\ArrayHelper;

/**
 * Class UrlHelper
 *
 * @package AndreasGlaser\Helpers\Http
 * @author  Andreas Glaser
 */
class UrlHelper
{

    /**
     * Returns string of protocol, server name and port of server-side configured values.
     *
     * e.g.:
     * http://example.com
     * http://example.com:8080 (if custom http port is used)
     * https://example.com:444 (if custom https port is used)
     *
     * @return null|string
     * @author Andreas Glaser
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

        $protocolAndHost = $protocol . '://';

        if ((!$isHttps && $serverPort !== 80) || ($isHttps && $serverPort !== 443)) {
            $protocolAndHost .= $serverName . ':' . $serverPort;
        } else {
            $protocolAndHost .= $serverName;
        }

        return $protocolAndHost;
    }

    /**
     * Builds query part of url.
     *
     * @param array $parameters
     * @param bool  $mergeGetVariables
     *
     * @return null|string
     *
     * @author Andreas Glaser
     */
    public static function query(array $parameters = null, $mergeGetVariables = true)
    {
        if ($mergeGetVariables) {
            if ($parameters === null) {
                $parameters = $_GET;
            } else {
                $parameters = ArrayHelper::merge($_GET, $parameters);
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
     *
     * @author Andreas Glaser
     */
    public static function currentUrl($includeQuery = true, $urlEncode = false)
    {
        // cli application
        if (RequestHelper::isCli()) {
            return null;
        }

        $url = static::protocolHostPort();

        if (!$includeQuery) {
            $url = substr($url, 0, strpos($url, '?'));
        }

        return $urlEncode ? urlencode($url) : $url;
    }

    /**
     * @param bool $includeQueryParams
     * @param bool $encode
     *
     * @return null|string
     *
     * @author Andreas Glaser
     */
    public static function currentUri($includeQueryParams = true, $encode = false)
    {
        // cli application
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