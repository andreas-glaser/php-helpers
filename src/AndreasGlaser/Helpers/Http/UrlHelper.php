<?php

namespace AndreasGlaser\Helpers\Html;

use AndreasGlaser\Helpers\Http;

/**
 * Class UrlHelper
 *
 * @package Helpers\Html
 *
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
                $parameters = array_merge($_GET, $parameters);
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
        if (!isset($_SERVER['HTTPS'])) {
            return null;
        }

        $url = 'http';
        if ($_SERVER['HTTPS'] === 'on') {
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
     * @param bool $inlcudeQuery
     * @param bool $encode
     *
     * @return null|string
     *
     * @author Andreas Glaser
     */
    public static function currentUri($inlcudeQuery = true, $encode = false)
    {
        // cli application
        if (!isset($_SERVER['HTTPS'])) {
            return null;
        }

        $uri = $_SERVER['REQUEST_URI'];
        if (!$inlcudeQuery) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        return $encode ? urlencode($uri) : $uri;
    }
}