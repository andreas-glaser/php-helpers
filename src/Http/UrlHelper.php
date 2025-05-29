<?php

namespace AndreasGlaser\Helpers\Http;

/**
 * UrlHelper provides comprehensive utility methods for working with URLs and server environment.
 * 
 * This class contains methods for:
 * - Building protocol, host, and port strings
 * - Generating and manipulating query strings
 * - Retrieving current URL and URI information
 * - URL parsing, validation, and manipulation
 * - URL encoding and decoding utilities
 * - Path and domain extraction
 * - URL building and reconstruction
 */
class UrlHelper
{
    /**
     * URL schemes
     */
    public const SCHEME_HTTP = 'http';
    public const SCHEME_HTTPS = 'https';
    public const SCHEME_FTP = 'ftp';
    public const SCHEME_SFTP = 'sftp';
    public const SCHEME_FILE = 'file';

    /**
     * Standard ports for common schemes
     */
    public const STANDARD_PORTS = [
        'http' => 80,
        'https' => 443,
        'ftp' => 21,
        'sftp' => 22,
        'ssh' => 22,
        'telnet' => 23,
        'smtp' => 25,
        'dns' => 53,
        'pop3' => 110,
        'imap' => 143,
        'snmp' => 161,
        'ldap' => 389,
        'smtps' => 465,
        'imaps' => 993,
        'pop3s' => 995
    ];

    // ========================================
    // Current URL/URI Methods
    // ========================================

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
    public static function protocolHostPort(): ?string
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
    public static function query(array $parameters = null, bool $mergeGetVariables = true): ?string
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
    public static function currentUrl(bool $includeQuery = true, bool $urlEncode = false): ?string
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
    public static function currentUri(bool $includeQueryParams = true, bool $encode = false): ?string
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

    // ========================================
    // URL Parsing and Validation
    // ========================================

    /**
     * Validates if a string is a valid URL.
     *
     * @param string $url The URL to validate
     * @param array $allowedSchemes Allowed schemes (default: ['http', 'https'])
     * @return bool True if valid URL, false otherwise
     */
    public static function isValidUrl(string $url, array $allowedSchemes = ['http', 'https']): bool
    {
        if (empty($url)) {
            return false;
        }

        $parsedUrl = parse_url($url);
        
        if ($parsedUrl === false || !isset($parsedUrl['scheme']) || !isset($parsedUrl['host'])) {
            return false;
        }

        if (!empty($allowedSchemes) && !in_array(strtolower($parsedUrl['scheme']), $allowedSchemes, true)) {
            return false;
        }

        // Validate with filter_var as additional check
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Parses a URL and returns its components.
     *
     * @param string $url The URL to parse
     * @return array|null Array of URL components or null if invalid
     */
    public static function parseUrl(string $url): ?array
    {
        $parsed = parse_url($url);
        
        if ($parsed === false) {
            return null;
        }

        // Add default values for missing components
        return array_merge([
            'scheme' => null,
            'host' => null,
            'port' => null,
            'user' => null,
            'pass' => null,
            'path' => null,
            'query' => null,
            'fragment' => null
        ], $parsed);
    }

    /**
     * Builds a URL from components.
     *
     * @param array $components URL components (scheme, host, port, user, pass, path, query, fragment)
     * @return string The built URL
     */
    public static function buildUrl(array $components): string
    {
        $url = '';

        if (!empty($components['scheme'])) {
            $url .= $components['scheme'] . '://';
        }

        if (!empty($components['user'])) {
            $url .= $components['user'];
            if (!empty($components['pass'])) {
                $url .= ':' . $components['pass'];
            }
            $url .= '@';
        }

        if (!empty($components['host'])) {
            $url .= $components['host'];
        }

        if (!empty($components['port']) && !static::isStandardPort($components['scheme'] ?? '', $components['port'])) {
            $url .= ':' . $components['port'];
        }

        if (!empty($components['path'])) {
            if (!str_starts_with($components['path'], '/')) {
                $url .= '/';
            }
            $url .= $components['path'];
        }

        if (!empty($components['query'])) {
            $url .= '?' . $components['query'];
        }

        if (!empty($components['fragment'])) {
            $url .= '#' . $components['fragment'];
        }

        return $url;
    }

    /**
     * Checks if a port is the standard port for a given scheme.
     *
     * @param string $scheme The URL scheme
     * @param int $port The port number
     * @return bool True if it's a standard port, false otherwise
     */
    public static function isStandardPort(string $scheme, int $port): bool
    {
        $scheme = strtolower($scheme);
        return isset(static::STANDARD_PORTS[$scheme]) && static::STANDARD_PORTS[$scheme] === $port;
    }

    // ========================================
    // URL Manipulation
    // ========================================

    /**
     * Adds or modifies query parameters in a URL.
     *
     * @param string $url The original URL
     * @param array $params Parameters to add or modify
     * @param bool $encode Whether to URL encode parameter values
     * @return string The modified URL
     */
    public static function addQueryParams(string $url, array $params, bool $encode = true): string
    {
        if (empty($params)) {
            return $url;
        }

        $parsed = static::parseUrl($url);
        if (!$parsed) {
            return $url;
        }

        // Parse existing query parameters
        $queryParams = [];
        if (!empty($parsed['query'])) {
            parse_str($parsed['query'], $queryParams);
        }

        // Merge with new parameters
        $queryParams = array_merge($queryParams, $params);

        // Rebuild URL with new query
        $parsed['query'] = http_build_query($queryParams, '', '&', $encode ? PHP_QUERY_RFC3986 : PHP_QUERY_RFC1738);

        return static::buildUrl($parsed);
    }

    /**
     * Removes query parameters from a URL.
     *
     * @param string $url The original URL
     * @param array $paramsToRemove Parameter names to remove
     * @return string The modified URL
     */
    public static function removeQueryParams(string $url, array $paramsToRemove): string
    {
        if (empty($paramsToRemove)) {
            return $url;
        }

        $parsed = static::parseUrl($url);
        if (!$parsed || empty($parsed['query'])) {
            return $url;
        }

        parse_str($parsed['query'], $queryParams);

        foreach ($paramsToRemove as $param) {
            unset($queryParams[$param]);
        }

        if (empty($queryParams)) {
            $parsed['query'] = null;
        } else {
            $parsed['query'] = http_build_query($queryParams);
        }

        return static::buildUrl($parsed);
    }

    /**
     * Changes the scheme of a URL.
     *
     * @param string $url The original URL
     * @param string $scheme The new scheme (e.g., 'https')
     * @return string The modified URL
     */
    public static function changeScheme(string $url, string $scheme): string
    {
        $parsed = static::parseUrl($url);
        if (!$parsed) {
            return $url;
        }

        $parsed['scheme'] = $scheme;

        // Remove port if it's now standard for the new scheme
        if (!empty($parsed['port']) && static::isStandardPort($scheme, $parsed['port'])) {
            $parsed['port'] = null;
        }

        return static::buildUrl($parsed);
    }

    /**
     * Normalizes a URL by cleaning up common issues.
     *
     * @param string $url The URL to normalize
     * @return string The normalized URL
     */
    public static function normalize(string $url): string
    {
        $url = trim($url);
        
        // Add scheme if missing
        if (!preg_match('/^[a-z][a-z0-9+.-]*:/i', $url)) {
            $url = 'http://' . $url;
        }

        $parsed = static::parseUrl($url);
        if (!$parsed) {
            return $url;
        }

        // Normalize scheme and host to lowercase
        if (!empty($parsed['scheme'])) {
            $parsed['scheme'] = strtolower($parsed['scheme']);
        }
        if (!empty($parsed['host'])) {
            $parsed['host'] = strtolower($parsed['host']);
        }

        // Normalize path
        if (!empty($parsed['path'])) {
            $parsed['path'] = static::normalizePath($parsed['path']);
        } else {
            $parsed['path'] = '/';
        }

        // Remove default ports
        if (!empty($parsed['port']) && static::isStandardPort($parsed['scheme'], $parsed['port'])) {
            $parsed['port'] = null;
        }

        return static::buildUrl($parsed);
    }

    // ========================================
    // Path Manipulation
    // ========================================

    /**
     * Normalizes a URL path by resolving . and .. segments.
     *
     * @param string $path The path to normalize
     * @return string The normalized path
     */
    public static function normalizePath(string $path): string
    {
        if (empty($path)) {
            return '/';
        }

        $segments = explode('/', $path);
        $normalizedSegments = [];

        foreach ($segments as $segment) {
            if ($segment === '' || $segment === '.') {
                continue;
            }
            
            if ($segment === '..') {
                if (!empty($normalizedSegments)) {
                    array_pop($normalizedSegments);
                }
            } else {
                $normalizedSegments[] = $segment;
            }
        }

        $normalizedPath = '/' . implode('/', $normalizedSegments);
        
        // Preserve trailing slash if original had one (except for root)
        if ($normalizedPath !== '/' && str_ends_with($path, '/')) {
            $normalizedPath .= '/';
        }

        return $normalizedPath;
    }

    /**
     * Joins path segments into a single path.
     *
     * @param string ...$segments Path segments to join
     * @return string The joined path
     */
    public static function joinPaths(string ...$segments): string
    {
        if (empty($segments)) {
            return '';
        }

        $path = '';
        $isAbsolute = str_starts_with($segments[0], '/');

        foreach ($segments as $segment) {
            $segment = trim($segment, '/');
            if ($segment !== '') {
                if ($path !== '') {
                    $path .= '/';
                }
                $path .= $segment;
            }
        }

        return ($isAbsolute ? '/' : '') . $path;
    }

    /**
     * Gets the directory path from a URL path.
     *
     * @param string $path The URL path
     * @return string The directory path
     */
    public static function getDirectory(string $path): string
    {
        return dirname($path);
    }

    /**
     * Gets the filename from a URL path.
     *
     * @param string $path The URL path
     * @return string The filename
     */
    public static function getFilename(string $path): string
    {
        return basename($path);
    }

    /**
     * Gets the file extension from a URL path.
     *
     * @param string $path The URL path
     * @return string The file extension (without dot)
     */
    public static function getExtension(string $path): string
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    // ========================================
    // Domain and Host Utilities
    // ========================================

    /**
     * Extracts the domain from a URL.
     *
     * @param string $url The URL
     * @return string|null The domain or null if invalid
     */
    public static function getDomain(string $url): ?string
    {
        $parsed = static::parseUrl($url);
        return $parsed['host'] ?? null;
    }

    /**
     * Extracts the subdomain from a URL.
     *
     * @param string $url The URL
     * @param int $levels Number of domain levels to consider as root domain (default: 2)
     * @return string|null The subdomain or null if none
     */
    public static function getSubdomain(string $url, int $levels = 2): ?string
    {
        $domain = static::getDomain($url);
        if (!$domain) {
            return null;
        }

        $parts = explode('.', $domain);
        if (count($parts) <= $levels) {
            return null;
        }

        return implode('.', array_slice($parts, 0, count($parts) - $levels));
    }

    /**
     * Gets the root domain from a URL.
     *
     * @param string $url The URL
     * @param int $levels Number of levels to include in root domain (default: 2)
     * @return string|null The root domain or null if invalid
     */
    public static function getRootDomain(string $url, int $levels = 2): ?string
    {
        $domain = static::getDomain($url);
        if (!$domain) {
            return null;
        }

        $parts = explode('.', $domain);
        if (count($parts) < $levels) {
            return $domain;
        }

        return implode('.', array_slice($parts, -$levels));
    }

    /**
     * Checks if two URLs are from the same domain.
     *
     * @param string $url1 First URL
     * @param string $url2 Second URL
     * @return bool True if same domain, false otherwise
     */
    public static function isSameDomain(string $url1, string $url2): bool
    {
        $domain1 = static::getDomain($url1);
        $domain2 = static::getDomain($url2);

        return $domain1 && $domain2 && $domain1 === $domain2;
    }

    // ========================================
    // Encoding and Decoding
    // ========================================

    /**
     * URL encodes a string with proper RFC 3986 compliance.
     *
     * @param string $string The string to encode
     * @return string The encoded string
     */
    public static function encode(string $string): string
    {
        return rawurlencode($string);
    }

    /**
     * URL decodes a string.
     *
     * @param string $string The string to decode
     * @return string The decoded string
     */
    public static function decode(string $string): string
    {
        return rawurldecode($string);
    }

    /**
     * Encodes only the path component of a URL.
     *
     * @param string $path The path to encode
     * @return string The encoded path
     */
    public static function encodePath(string $path): string
    {
        $segments = explode('/', $path);
        $encodedSegments = array_map([static::class, 'encode'], $segments);
        return implode('/', $encodedSegments);
    }

    /**
     * Encodes query string parameters.
     *
     * @param array $params The parameters to encode
     * @param bool $rfc3986 Whether to use RFC 3986 encoding (default: true)
     * @return string The encoded query string
     */
    public static function encodeQuery(array $params, bool $rfc3986 = true): string
    {
        return http_build_query($params, '', '&', $rfc3986 ? PHP_QUERY_RFC3986 : PHP_QUERY_RFC1738);
    }

    // ========================================
    // URL Conversion and Transformation
    // ========================================

    /**
     * Converts a relative URL to an absolute URL.
     *
     * @param string $relativeUrl The relative URL
     * @param string $baseUrl The base URL
     * @return string The absolute URL
     */
    public static function toAbsolute(string $relativeUrl, string $baseUrl): string
    {
        if (static::isValidUrl($relativeUrl)) {
            return $relativeUrl; // Already absolute
        }

        $base = static::parseUrl($baseUrl);
        if (!$base || !$base['scheme'] || !$base['host']) {
            return $relativeUrl; // Invalid base URL
        }

        // Handle protocol-relative URLs
        if (str_starts_with($relativeUrl, '//')) {
            return $base['scheme'] . ':' . $relativeUrl;
        }

        // Handle absolute paths
        if (str_starts_with($relativeUrl, '/')) {
            return $base['scheme'] . '://' . $base['host'] . 
                   (!empty($base['port']) && !static::isStandardPort($base['scheme'], $base['port']) ? ':' . $base['port'] : '') . 
                   $relativeUrl;
        }

        // Handle relative paths
        $basePath = $base['path'] ?? '/';
        if (!str_ends_with($basePath, '/')) {
            $basePath = dirname($basePath) . '/';
        }

        $absolutePath = static::normalizePath($basePath . $relativeUrl);

        return $base['scheme'] . '://' . $base['host'] . 
               (!empty($base['port']) && !static::isStandardPort($base['scheme'], $base['port']) ? ':' . $base['port'] : '') . 
               $absolutePath;
    }

    /**
     * Converts an absolute URL to a relative URL.
     *
     * @param string $absoluteUrl The absolute URL
     * @param string $baseUrl The base URL to make it relative to
     * @return string The relative URL
     */
    public static function toRelative(string $absoluteUrl, string $baseUrl): string
    {
        $absolute = static::parseUrl($absoluteUrl);
        $base = static::parseUrl($baseUrl);

        if (!$absolute || !$base) {
            return $absoluteUrl;
        }

        // Different schemes or hosts
        if ($absolute['scheme'] !== $base['scheme'] || $absolute['host'] !== $base['host']) {
            return $absoluteUrl;
        }

        // Different ports
        if (($absolute['port'] ?? null) !== ($base['port'] ?? null)) {
            return $absoluteUrl;
        }

        $absolutePath = $absolute['path'] ?? '/';
        $basePath = $base['path'] ?? '/';

        // Find common path
        $absoluteSegments = explode('/', trim($absolutePath, '/'));
        $baseSegments = explode('/', trim($basePath, '/'));

        $commonLength = 0;
        $minLength = min(count($absoluteSegments), count($baseSegments));

        for ($i = 0; $i < $minLength; $i++) {
            if ($absoluteSegments[$i] === $baseSegments[$i]) {
                $commonLength++;
            } else {
                break;
            }
        }

        // Build relative path
        $relativePath = str_repeat('../', count($baseSegments) - $commonLength);
        $relativePath .= implode('/', array_slice($absoluteSegments, $commonLength));

        // Add query and fragment if present
        if (!empty($absolute['query'])) {
            $relativePath .= '?' . $absolute['query'];
        }
        if (!empty($absolute['fragment'])) {
            $relativePath .= '#' . $absolute['fragment'];
        }

        return $relativePath ?: './';
    }

    // ========================================
    // Utility Methods
    // ========================================

    /**
     * Gets the current page URL with optional modifications.
     *
     * @param array $queryModifications Query parameters to add/modify
     * @param array $queryRemovals Query parameters to remove
     * @return string|null The modified current URL
     */
    public static function currentUrlWithModifications(array $queryModifications = [], array $queryRemovals = []): ?string
    {
        $currentUrl = static::currentUrl();
        if (!$currentUrl) {
            return null;
        }

        if (!empty($queryRemovals)) {
            $currentUrl = static::removeQueryParams($currentUrl, $queryRemovals);
        }

        if (!empty($queryModifications)) {
            $currentUrl = static::addQueryParams($currentUrl, $queryModifications);
        }

        return $currentUrl;
    }

    /**
     * Checks if a URL is using a secure scheme (HTTPS).
     *
     * @param string $url The URL to check
     * @return bool True if secure, false otherwise
     */
    public static function isSecureUrl(string $url): bool
    {
        $parsed = static::parseUrl($url);
        return $parsed && strtolower($parsed['scheme'] ?? '') === 'https';
    }

    /**
     * Gets the standard port for a scheme.
     *
     * @param string $scheme The scheme
     * @return int|null The standard port or null if unknown
     */
    public static function getStandardPort(string $scheme): ?int
    {
        return static::STANDARD_PORTS[strtolower($scheme)] ?? null;
    }

    /**
     * Sanitizes a URL by removing dangerous characters and protocols.
     *
     * @param string $url The URL to sanitize
     * @param array $allowedSchemes Allowed schemes (default: ['http', 'https'])
     * @return string|null The sanitized URL or null if invalid
     */
    public static function sanitize(string $url, array $allowedSchemes = ['http', 'https']): ?string
    {
        $url = trim($url);
        
        // Remove dangerous protocols
        $dangerousSchemes = ['javascript', 'vbscript', 'data', 'file'];
        foreach ($dangerousSchemes as $scheme) {
            if (stripos($url, $scheme . ':') === 0) {
                return null;
            }
        }

        // Validate URL
        if (!static::isValidUrl($url, $allowedSchemes)) {
            return null;
        }

        return static::normalize($url);
    }

    /**
     * Generates a query string from the current URL with modifications.
     *
     * @param array $params Parameters to add or modify
     * @param array $remove Parameters to remove
     * @return string The generated query string
     */
    public static function modifiedQuery(array $params = [], array $remove = []): string
    {
        $currentParams = $_GET;

        // Remove specified parameters
        foreach ($remove as $key) {
            unset($currentParams[$key]);
        }

        // Add/modify parameters
        $currentParams = array_merge($currentParams, $params);

        return empty($currentParams) ? '' : '?' . http_build_query($currentParams);
    }
}
