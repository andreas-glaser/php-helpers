<?php

namespace AndreasGlaser\Helpers\Http;

/**
 * RequestHelper provides comprehensive utility methods for analyzing and working with HTTP requests.
 * 
 * This class contains methods for:
 * - Environment detection (CLI mode, HTTPS)
 * - Request method analysis (GET, POST, PUT, DELETE, etc.)
 * - Client information (IP address, user agent, device type)
 * - Request type detection (AJAX, API, mobile)
 * - Security and validation (secure connections, trusted proxies)
 * - Content analysis (content type, encoding, language)
 * - Header management and analysis
 * - Request timing and performance metrics
 */
class RequestHelper
{
    /**
     * Common HTTP methods
     */
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';
    public const METHOD_HEAD = 'HEAD';
    public const METHOD_OPTIONS = 'OPTIONS';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_TRACE = 'TRACE';
    public const METHOD_CONNECT = 'CONNECT';

    /**
     * Common content types
     */
    public const CONTENT_TYPE_JSON = 'application/json';
    public const CONTENT_TYPE_XML = 'application/xml';
    public const CONTENT_TYPE_HTML = 'text/html';
    public const CONTENT_TYPE_PLAIN = 'text/plain';
    public const CONTENT_TYPE_FORM = 'application/x-www-form-urlencoded';
    public const CONTENT_TYPE_MULTIPART = 'multipart/form-data';

    /**
     * Trusted proxy headers for IP detection
     */
    private static array $trustedProxyHeaders = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];

    // ========================================
    // Environment Detection Methods
    // ========================================

    /**
     * Checks if the script is running in CLI mode.
     * 
     * Enhanced method that checks multiple indicators for CLI mode including
     * REQUEST_METHOD absence, PHP_SAPI, and command line arguments.
     * Priority is given to REQUEST_METHOD when explicitly set for testing purposes.
     *
     * @return bool True if running in CLI mode, false otherwise
     */
    public static function isCli(): bool
    {
        // Primary check - if REQUEST_METHOD is set, we're likely in web mode
        // This helps with testing scenarios where we simulate web environment
        if (isset($_SERVER['REQUEST_METHOD'])) {
            return false;
        }

        // Secondary check - PHP SAPI (only if REQUEST_METHOD is not set)
        if (defined('PHP_SAPI') && in_array(PHP_SAPI, ['cli', 'phpdbg'], true)) {
            return true;
        }

        // Tertiary check - common CLI environment variables
        if (isset($_SERVER['argv']) || isset($_SERVER['argc'])) {
            return true;
        }

        return false;
    }

    /**
     * Checks if the current request is using HTTPS.
     * 
     * Enhanced method that checks multiple indicators for secure connections
     * including proxy headers and load balancer configurations.
     *
     * @return bool True if using HTTPS, false otherwise
     */
    public static function isHttps(): bool
    {
        // Primary check - HTTPS server variable
        if (isset($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS'])) {
            return true;
        }

        // Check for load balancer/proxy HTTPS indicators
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && 
            strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
            return true;
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && 
            strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) === 'on') {
            return true;
        }

        // Check for secure port
        if (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443) {
            return true;
        }

        // Check CloudFlare and other CDN headers
        if (isset($_SERVER['HTTP_CF_VISITOR'])) {
            $visitor = json_decode($_SERVER['HTTP_CF_VISITOR'], true);
            if (isset($visitor['scheme']) && $visitor['scheme'] === 'https') {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if the request is secure (HTTPS or from localhost).
     *
     * @return bool True if request is secure, false otherwise
     */
    public static function isSecure(): bool
    {
        return static::isHttps() || static::isLocalhost();
    }

    /**
     * Checks if the request is from localhost.
     *
     * @return bool True if from localhost, false otherwise
     */
    public static function isLocalhost(): bool
    {
        $ip = static::getClientIp();
        
        return in_array($ip, ['127.0.0.1', '::1', 'localhost'], true) ||
               (isset($_SERVER['SERVER_NAME']) && 
                in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1'], true));
    }

    // ========================================
    // Request Method Analysis
    // ========================================

    /**
     * Gets the HTTP request method.
     *
     * @return string|null The request method (GET, POST, etc.) or null if in CLI mode
     */
    public static function getMethod(): ?string
    {
        if (static::isCli()) {
            return null;
        }

        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    /**
     * Checks if the request method matches the given method.
     *
     * @param string $method The method to check against
     * @return bool True if methods match, false otherwise
     */
    public static function isMethod(string $method): bool
    {
        return static::getMethod() === strtoupper($method);
    }

    /**
     * Checks if the request is a GET request.
     *
     * @return bool True if GET request, false otherwise
     */
    public static function isGet(): bool
    {
        return static::isMethod(static::METHOD_GET);
    }

    /**
     * Checks if the request is a POST request.
     *
     * @return bool True if POST request, false otherwise
     */
    public static function isPost(): bool
    {
        return static::isMethod(static::METHOD_POST);
    }

    /**
     * Checks if the request is a PUT request.
     *
     * @return bool True if PUT request, false otherwise
     */
    public static function isPut(): bool
    {
        return static::isMethod(static::METHOD_PUT);
    }

    /**
     * Checks if the request is a DELETE request.
     *
     * @return bool True if DELETE request, false otherwise
     */
    public static function isDelete(): bool
    {
        return static::isMethod(static::METHOD_DELETE);
    }

    /**
     * Checks if the request is a HEAD request.
     *
     * @return bool True if HEAD request, false otherwise
     */
    public static function isHead(): bool
    {
        return static::isMethod(static::METHOD_HEAD);
    }

    /**
     * Checks if the request is an OPTIONS request.
     *
     * @return bool True if OPTIONS request, false otherwise
     */
    public static function isOptions(): bool
    {
        return static::isMethod(static::METHOD_OPTIONS);
    }

    /**
     * Checks if the request is a PATCH request.
     *
     * @return bool True if PATCH request, false otherwise
     */
    public static function isPatch(): bool
    {
        return static::isMethod(static::METHOD_PATCH);
    }

    // ========================================
    // Request Type Detection
    // ========================================

    /**
     * Checks if the request is an AJAX/XMLHttpRequest.
     *
     * @return bool True if AJAX request, false otherwise
     */
    public static function isAjax(): bool
    {
        if (static::isCli()) {
            return false;
        }

        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Checks if the request is likely an API request.
     *
     * @return bool True if API request, false otherwise
     */
    public static function isApi(): bool
    {
        if (static::isCli()) {
            return false;
        }

        // Check for API-like paths
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        if (preg_match('/^\/api(\/|$)/', $uri)) {
            return true;
        }

        // Check for JSON content type
        if (static::isContentType(static::CONTENT_TYPE_JSON)) {
            return true;
        }

        // Check for API-like Accept headers
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
        if (strpos($accept, 'application/json') !== false) {
            return true;
        }

        return false;
    }

    /**
     * Checks if the request is from a mobile device.
     *
     * @return bool True if mobile request, false otherwise
     */
    public static function isMobile(): bool
    {
        if (static::isCli()) {
            return false;
        }

        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        $mobileKeywords = [
            'Mobile', 'Android', 'iPhone', 'iPad', 'iPod', 'BlackBerry', 
            'Windows Phone', 'webOS', 'Opera Mini', 'IEMobile', 'Mobile Safari'
        ];

        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if the request is from a bot/crawler.
     *
     * @return bool True if bot request, false otherwise
     */
    public static function isBot(): bool
    {
        if (static::isCli()) {
            return false;
        }

        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
        
        $botKeywords = [
            'bot', 'crawler', 'spider', 'scraper', 'slurp', 'yahoo', 'bing',
            'google', 'facebook', 'twitter', 'linkedin', 'pinterest', 'curl',
            'wget', 'python', 'java', 'perl', 'ruby', 'php'
        ];

        foreach ($botKeywords as $keyword) {
            if (strpos($userAgent, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    // ========================================
    // Client Information
    // ========================================

    /**
     * Gets the client's IP address with proxy support.
     *
     * @param bool $trustProxies Whether to trust proxy headers
     * @return string The client IP address
     */
    public static function getClientIp(bool $trustProxies = true): string
    {
        if (static::isCli()) {
            return '127.0.0.1';
        }

        if ($trustProxies) {
            foreach (static::$trustedProxyHeaders as $header) {
                if (!empty($_SERVER[$header])) {
                    $ips = explode(',', $_SERVER[$header]);
                    $ip = trim($ips[0]);
                    
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                        return $ip;
                    }
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    /**
     * Gets the user agent string.
     *
     * @return string The user agent string
     */
    public static function getUserAgent(): string
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? '';
    }

    /**
     * Gets the referrer URL.
     *
     * @return string|null The referrer URL or null if not available
     */
    public static function getReferrer(): ?string
    {
        return $_SERVER['HTTP_REFERER'] ?? null;
    }

    /**
     * Gets the request protocol (HTTP/1.1, HTTP/2, etc.).
     *
     * @return string The request protocol
     */
    public static function getProtocol(): string
    {
        return $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.1';
    }

    /**
     * Gets the request port.
     *
     * @return int The request port
     */
    public static function getPort(): int
    {
        return (int)($_SERVER['SERVER_PORT'] ?? (static::isHttps() ? 443 : 80));
    }

    /**
     * Gets the host name.
     *
     * @return string The host name
     */
    public static function getHost(): string
    {
        return $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
    }

    // ========================================
    // Content Analysis
    // ========================================

    /**
     * Gets the request content type.
     *
     * @return string|null The content type or null if not set
     */
    public static function getContentType(): ?string
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? $_SERVER['HTTP_CONTENT_TYPE'] ?? null;
        
        if ($contentType && strpos($contentType, ';') !== false) {
            $contentType = trim(explode(';', $contentType)[0]);
        }

        return $contentType;
    }

    /**
     * Checks if the request content type matches the given type.
     *
     * @param string $type The content type to check
     * @return bool True if content types match, false otherwise
     */
    public static function isContentType(string $type): bool
    {
        $currentType = static::getContentType();
        return $currentType && strcasecmp($currentType, $type) === 0;
    }

    /**
     * Checks if the request has JSON content type.
     *
     * @return bool True if JSON content type, false otherwise
     */
    public static function isJson(): bool
    {
        return static::isContentType(static::CONTENT_TYPE_JSON);
    }

    /**
     * Checks if the request has XML content type.
     *
     * @return bool True if XML content type, false otherwise
     */
    public static function isXml(): bool
    {
        return static::isContentType(static::CONTENT_TYPE_XML);
    }

    /**
     * Gets the content length.
     *
     * @return int|null The content length or null if not available
     */
    public static function getContentLength(): ?int
    {
        $length = $_SERVER['CONTENT_LENGTH'] ?? $_SERVER['HTTP_CONTENT_LENGTH'] ?? null;
        return $length !== null ? (int)$length : null;
    }

    /**
     * Gets the accepted languages from Accept-Language header.
     *
     * @return array Array of accepted languages sorted by preference
     */
    public static function getAcceptedLanguages(): array
    {
        $header = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
        if (empty($header)) {
            return [];
        }

        $languages = [];
        $items = explode(',', $header);

        foreach ($items as $item) {
            $parts = explode(';', trim($item));
            $lang = trim($parts[0]);
            $quality = 1.0;

            if (isset($parts[1]) && strpos($parts[1], 'q=') === 0) {
                $quality = (float)substr($parts[1], 2);
            }

            $languages[$lang] = $quality;
        }

        arsort($languages);
        return array_keys($languages);
    }

    // ========================================
    // Header Management
    // ========================================

    /**
     * Gets a specific request header.
     *
     * @param string $name The header name
     * @param mixed $default Default value if header not found
     * @return mixed The header value or default
     */
    public static function getHeader(string $name, $default = null)
    {
        // Normalize header name
        $headerKey = 'HTTP_' . strtoupper(str_replace('-', '_', $name));
        
        return $_SERVER[$headerKey] ?? $default;
    }

    /**
     * Checks if a specific header exists.
     *
     * @param string $name The header name
     * @return bool True if header exists, false otherwise
     */
    public static function hasHeader(string $name): bool
    {
        $headerKey = 'HTTP_' . strtoupper(str_replace('-', '_', $name));
        return isset($_SERVER[$headerKey]);
    }

    /**
     * Gets all request headers.
     *
     * @return array Associative array of headers
     */
    public static function getAllHeaders(): array
    {
        if (function_exists('getallheaders')) {
            return getallheaders() ?: [];
        }

        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headerName = str_replace('_', '-', substr($key, 5));
                $headerName = ucwords(strtolower($headerName), '-');
                $headers[$headerName] = $value;
            }
        }

        return $headers;
    }

    // ========================================
    // Security and Validation
    // ========================================

    /**
     * Checks if the request appears to be legitimate (basic security check).
     *
     * @return bool True if request appears legitimate, false otherwise
     */
    public static function isLegitimate(): bool
    {
        // Check for user agent (bots may not have one, but legitimate browsers should)
        if (empty($_SERVER['HTTP_USER_AGENT']) && !static::isCli()) {
            return false;
        }

        // Check for suspicious patterns
        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
        $suspiciousPatterns = ['<script', 'javascript:', 'vbscript:', 'onload='];
        
        foreach ($suspiciousPatterns as $pattern) {
            if (strpos($userAgent, $pattern) !== false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Gets the request timestamp.
     *
     * @return float The request timestamp
     */
    public static function getRequestTime(): float
    {
        return $_SERVER['REQUEST_TIME_FLOAT'] ?? $_SERVER['REQUEST_TIME'] ?? microtime(true);
    }

    /**
     * Checks if the request is within rate limits (basic implementation).
     *
     * @param int $maxRequests Maximum requests allowed
     * @param int $timeWindow Time window in seconds
     * @param string|null $identifier Identifier for rate limiting (defaults to IP)
     * @return bool True if within limits, false otherwise
     */
    public static function isWithinRateLimit(int $maxRequests, int $timeWindow, ?string $identifier = null): bool
    {
        if (static::isCli()) {
            return true;
        }

        $identifier = $identifier ?? static::getClientIp();
        $key = 'rate_limit_' . md5($identifier);
        
        // Simple file-based rate limiting (in production, use Redis/Memcached)
        $file = sys_get_temp_dir() . '/' . $key;
        
        if (!file_exists($file)) {
            file_put_contents($file, json_encode(['count' => 1, 'timestamp' => time()]));
            return true;
        }

        $data = json_decode(file_get_contents($file), true);
        $currentTime = time();

        if ($currentTime - $data['timestamp'] > $timeWindow) {
            // Reset counter
            file_put_contents($file, json_encode(['count' => 1, 'timestamp' => $currentTime]));
            return true;
        }

        if ($data['count'] >= $maxRequests) {
            return false;
        }

        // Increment counter
        $data['count']++;
        file_put_contents($file, json_encode($data));
        return true;
    }

    // ========================================
    // Utility Methods
    // ========================================

    /**
     * Gets comprehensive request information.
     *
     * @return array Array containing detailed request information
     */
    public static function getRequestInfo(): array
    {
        if (static::isCli()) {
            return [
                'environment' => 'CLI',
                'method' => null,
                'is_secure' => false,
                'timestamp' => microtime(true)
            ];
        }

        return [
            'environment' => 'Web',
            'method' => static::getMethod(),
            'uri' => $_SERVER['REQUEST_URI'] ?? '',
            'host' => static::getHost(),
            'port' => static::getPort(),
            'protocol' => static::getProtocol(),
            'is_secure' => static::isSecure(),
            'is_https' => static::isHttps(),
            'is_ajax' => static::isAjax(),
            'is_api' => static::isApi(),
            'is_mobile' => static::isMobile(),
            'is_bot' => static::isBot(),
            'client_ip' => static::getClientIp(),
            'user_agent' => static::getUserAgent(),
            'referrer' => static::getReferrer(),
            'content_type' => static::getContentType(),
            'content_length' => static::getContentLength(),
            'accepted_languages' => static::getAcceptedLanguages(),
            'timestamp' => static::getRequestTime(),
            'is_legitimate' => static::isLegitimate()
        ];
    }

    /**
     * Sets trusted proxy headers for IP detection.
     *
     * @param array $headers Array of trusted proxy header names
     * @return void
     */
    public static function setTrustedProxyHeaders(array $headers): void
    {
        static::$trustedProxyHeaders = $headers;
    }

    /**
     * Gets the current trusted proxy headers.
     *
     * @return array Array of trusted proxy header names
     */
    public static function getTrustedProxyHeaders(): array
    {
        return static::$trustedProxyHeaders;
    }
}
