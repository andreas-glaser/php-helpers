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

        $url = 'http';

        if (RequestHelper::isHttps()) {
            $url .= 's';
        }

        $url .= '://';

        if ((int)$_SERVER['SERVER_PORT'] !== 80) {
            $url .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
        } else {
            $url .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        }

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