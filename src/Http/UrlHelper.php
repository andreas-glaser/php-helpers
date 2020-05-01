<?php

namespace AndreasGlaser\Helpers\Http;

/**
 * Class UrlHelper.
 */
class UrlHelper
{
    /**
     * Returns string of protocol, server name and port of server-side configured values.
     * e.g.:
     * http://example.com
     * http://example.com:8080 (if custom http port is used)
     * https://example.com:444 (if custom https port is used).
     *
     * @return string|null
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
     * Builds query part of url.
     *
     * @param array $parameters
     *
     * @return string|null
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
     * @return string|null
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
     * @return string|null
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
