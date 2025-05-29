<?php

namespace Tests\Http;

use PHPUnit\Framework\TestCase;
use AndreasGlaser\Helpers\Http\RequestHelper;

/**
 * RequestHelperTest provides unit tests for the improved RequestHelper class.
 *
 * This class tests comprehensive request analysis methods:
 * - Environment detection (CLI mode, HTTPS, security)
 * - Request method analysis (GET, POST, PUT, DELETE, etc.)
 * - Client information (IP address, user agent, device type)
 * - Request type detection (AJAX, API, mobile, bot)
 * - Content analysis (content type, encoding, language)
 * - Header management and analysis
 * - Security and validation features
 * - Utility and information methods
 * 
 * Each method is tested with various server configurations, CLI mode,
 * different user agents, and edge cases.
 */
class RequestHelperTest extends TestCase
{
    /**
     * Store original $_SERVER values to restore after tests
     * @var array
     */
    private array $originalServer;

    /**
     * Set up test environment by storing original $_SERVER values
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->originalServer = $_SERVER;
    }

    /**
     * Restore original $_SERVER values after each test
     */
    protected function tearDown(): void
    {
        $_SERVER = $this->originalServer;
        parent::tearDown();
    }

    /**
     * Helper method to simulate web environment
     */
    private function setupWebEnvironment(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        unset($_SERVER['argv']);
        unset($_SERVER['argc']);
    }

    /**
     * Helper method to simulate CLI environment
     */
    private function setupCliEnvironment(): void
    {
        unset($_SERVER['REQUEST_METHOD']);
        $_SERVER['argv'] = ['script.php'];
        $_SERVER['argc'] = 1;
    }

    // ========================================
    // Environment Detection Tests
    // ========================================

    /**
     * Tests isCli() method in CLI mode.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isCli
     * @return void
     */
    public function testIsCliInCliMode()
    {
        $this->setupCliEnvironment();
        
        $result = RequestHelper::isCli();
        
        $this->assertTrue($result);
    }

    /**
     * Tests isCli() method in web mode.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isCli
     * @return void
     */
    public function testIsCliInWebMode()
    {
        $this->setupWebEnvironment();
        
        $result = RequestHelper::isCli();
        
        $this->assertFalse($result);
    }

    /**
     * Tests isCli() method with CLI SAPI but REQUEST_METHOD set.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isCli
     * @return void
     */
    public function testIsCliWithCliSapi()
    {
        $this->setupWebEnvironment();
        $_SERVER['argv'] = ['script.php']; // Add CLI indicator
        
        // With the new logic, REQUEST_METHOD takes priority, so this should be false
        $result = RequestHelper::isCli();
        
        $this->assertFalse($result);
    }

    /**
     * Tests isHttps() method with HTTPS on.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isHttps
     * @return void
     */
    public function testIsHttpsWithHttpsOn()
    {
        $_SERVER['HTTPS'] = 'on';
        
        $result = RequestHelper::isHttps();
        
        $this->assertTrue($result);
    }

    /**
     * Tests isHttps() method with HTTPS off.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isHttps
     * @return void
     */
    public function testIsHttpsWithHttpsOff()
    {
        $_SERVER['HTTPS'] = 'off';
        
        $result = RequestHelper::isHttps();
        
        $this->assertFalse($result);
    }

    /**
     * Tests isHttps() method with proxy headers.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isHttps
     * @return void
     */
    public function testIsHttpsWithProxyHeaders()
    {
        unset($_SERVER['HTTPS']);
        $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'https';
        
        $result = RequestHelper::isHttps();
        
        $this->assertTrue($result);
    }

    /**
     * Tests isHttps() method with CloudFlare visitor header.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isHttps
     * @return void
     */
    public function testIsHttpsWithCloudFlareHeader()
    {
        unset($_SERVER['HTTPS']);
        $_SERVER['HTTP_CF_VISITOR'] = '{"scheme":"https"}';
        
        $result = RequestHelper::isHttps();
        
        $this->assertTrue($result);
    }

    /**
     * Tests isSecure() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isSecure
     * @return void
     */
    public function testIsSecure()
    {
        $_SERVER['HTTPS'] = 'on';
        
        $result = RequestHelper::isSecure();
        
        $this->assertTrue($result);
    }

    /**
     * Tests isLocalhost() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isLocalhost
     * @return void
     */
    public function testIsLocalhost()
    {
        $this->setupWebEnvironment();
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        
        $result = RequestHelper::isLocalhost();
        
        $this->assertTrue($result);
    }

    // ========================================
    // Request Method Tests
    // ========================================

    /**
     * Tests getMethod() method in CLI mode.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getMethod
     * @return void
     */
    public function testGetMethodInCliMode()
    {
        $this->setupCliEnvironment();
        
        $result = RequestHelper::getMethod();
        
        $this->assertNull($result);
    }

    /**
     * Tests getMethod() with various HTTP methods.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getMethod
     * @return void
     */
    public function testGetMethodWithVariousMethods()
    {
        $methods = ['GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS', 'PATCH'];
        
        foreach ($methods as $method) {
            $this->setupWebEnvironment();
            $_SERVER['REQUEST_METHOD'] = $method;
            
            $result = RequestHelper::getMethod();
            
            $this->assertEquals($method, $result);
        }
    }

    /**
     * Tests HTTP method detection methods.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isGet
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isPost
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isPut
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isDelete
     * @return void
     */
    public function testHttpMethodDetection()
    {
        $this->setupWebEnvironment();
        $_SERVER['REQUEST_METHOD'] = 'POST';
        
        $this->assertFalse(RequestHelper::isGet());
        $this->assertTrue(RequestHelper::isPost());
        $this->assertFalse(RequestHelper::isPut());
        $this->assertFalse(RequestHelper::isDelete());
    }

    // ========================================
    // Request Type Detection Tests
    // ========================================

    /**
     * Tests isAjax() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isAjax
     * @return void
     */
    public function testIsAjax()
    {
        $this->setupWebEnvironment();
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        
        $result = RequestHelper::isAjax();
        
        $this->assertTrue($result);
    }

    /**
     * Tests isAjax() method without AJAX header.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isAjax
     * @return void
     */
    public function testIsAjaxWithoutHeader()
    {
        $this->setupWebEnvironment();
        unset($_SERVER['HTTP_X_REQUESTED_WITH']);
        
        $result = RequestHelper::isAjax();
        
        $this->assertFalse($result);
    }

    /**
     * Tests isApi() method with API path.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isApi
     * @return void
     */
    public function testIsApiWithApiPath()
    {
        $this->setupWebEnvironment();
        $_SERVER['REQUEST_URI'] = '/api/users';
        
        $result = RequestHelper::isApi();
        
        $this->assertTrue($result);
    }

    /**
     * Tests isApi() method with JSON content type.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isApi
     * @return void
     */
    public function testIsApiWithJsonContent()
    {
        $this->setupWebEnvironment();
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['CONTENT_TYPE'] = 'application/json';
        
        $result = RequestHelper::isApi();
        
        $this->assertTrue($result);
    }

    /**
     * Tests isMobile() method with mobile user agent.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isMobile
     * @return void
     */
    public function testIsMobileWithMobileUserAgent()
    {
        $this->setupWebEnvironment();
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)';
        
        $result = RequestHelper::isMobile();
        
        $this->assertTrue($result);
    }

    /**
     * Tests isMobile() method with desktop user agent.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isMobile
     * @return void
     */
    public function testIsMobileWithDesktopUserAgent()
    {
        $this->setupWebEnvironment();
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36';
        
        $result = RequestHelper::isMobile();
        
        $this->assertFalse($result);
    }

    /**
     * Tests isBot() method with bot user agent.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isBot
     * @return void
     */
    public function testIsBotWithBotUserAgent()
    {
        $this->setupWebEnvironment();
        $_SERVER['HTTP_USER_AGENT'] = 'Googlebot/2.1 (+http://www.google.com/bot.html)';
        
        $result = RequestHelper::isBot();
        
        $this->assertTrue($result);
    }

    // ========================================
    // Client Information Tests
    // ========================================

    /**
     * Tests getClientIp() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getClientIp
     * @return void
     */
    public function testGetClientIp()
    {
        $this->setupWebEnvironment();
        $_SERVER['REMOTE_ADDR'] = '192.168.1.100';
        
        $result = RequestHelper::getClientIp(false);
        
        $this->assertEquals('192.168.1.100', $result);
    }

    /**
     * Tests getClientIp() method with proxy headers.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getClientIp
     * @return void
     */
    public function testGetClientIpWithProxyHeaders()
    {
        $this->setupWebEnvironment();
        $_SERVER['REMOTE_ADDR'] = '10.0.0.1';
        $_SERVER['HTTP_X_FORWARDED_FOR'] = '203.0.113.10, 192.168.1.1';
        
        $result = RequestHelper::getClientIp(true);
        
        $this->assertEquals('203.0.113.10', $result);
    }

    /**
     * Tests getClientIp() in CLI mode.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getClientIp
     * @return void
     */
    public function testGetClientIpInCliMode()
    {
        $this->setupCliEnvironment();
        
        $result = RequestHelper::getClientIp();
        
        $this->assertEquals('127.0.0.1', $result);
    }

    /**
     * Tests getUserAgent() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getUserAgent
     * @return void
     */
    public function testGetUserAgent()
    {
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36';
        $_SERVER['HTTP_USER_AGENT'] = $userAgent;
        
        $result = RequestHelper::getUserAgent();
        
        $this->assertEquals($userAgent, $result);
    }

    /**
     * Tests getReferrer() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getReferrer
     * @return void
     */
    public function testGetReferrer()
    {
        $referrer = 'https://www.example.com/previous-page';
        $_SERVER['HTTP_REFERER'] = $referrer;
        
        $result = RequestHelper::getReferrer();
        
        $this->assertEquals($referrer, $result);
    }

    /**
     * Tests getProtocol() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getProtocol
     * @return void
     */
    public function testGetProtocol()
    {
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/2';
        
        $result = RequestHelper::getProtocol();
        
        $this->assertEquals('HTTP/2', $result);
    }

    /**
     * Tests getPort() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getPort
     * @return void
     */
    public function testGetPort()
    {
        $_SERVER['SERVER_PORT'] = '8080';
        
        $result = RequestHelper::getPort();
        
        $this->assertEquals(8080, $result);
    }

    /**
     * Tests getHost() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getHost
     * @return void
     */
    public function testGetHost()
    {
        $_SERVER['HTTP_HOST'] = 'www.example.com';
        
        $result = RequestHelper::getHost();
        
        $this->assertEquals('www.example.com', $result);
    }

    // ========================================
    // Content Analysis Tests
    // ========================================

    /**
     * Tests getContentType() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getContentType
     * @return void
     */
    public function testGetContentType()
    {
        $_SERVER['CONTENT_TYPE'] = 'application/json; charset=utf-8';
        
        $result = RequestHelper::getContentType();
        
        $this->assertEquals('application/json', $result);
    }

    /**
     * Tests isContentType() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isContentType
     * @return void
     */
    public function testIsContentType()
    {
        $_SERVER['CONTENT_TYPE'] = 'application/json';
        
        $result = RequestHelper::isContentType('application/json');
        
        $this->assertTrue($result);
    }

    /**
     * Tests isJson() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isJson
     * @return void
     */
    public function testIsJson()
    {
        $_SERVER['CONTENT_TYPE'] = 'application/json';
        
        $result = RequestHelper::isJson();
        
        $this->assertTrue($result);
    }

    /**
     * Tests isXml() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isXml
     * @return void
     */
    public function testIsXml()
    {
        $_SERVER['CONTENT_TYPE'] = 'application/xml';
        
        $result = RequestHelper::isXml();
        
        $this->assertTrue($result);
    }

    /**
     * Tests getContentLength() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getContentLength
     * @return void
     */
    public function testGetContentLength()
    {
        $_SERVER['CONTENT_LENGTH'] = '1024';
        
        $result = RequestHelper::getContentLength();
        
        $this->assertEquals(1024, $result);
    }

    /**
     * Tests getAcceptedLanguages() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getAcceptedLanguages
     * @return void
     */
    public function testGetAcceptedLanguages()
    {
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'en-US,en;q=0.9,de;q=0.8,fr;q=0.7';
        
        $result = RequestHelper::getAcceptedLanguages();
        
        $this->assertEquals(['en-US', 'en', 'de', 'fr'], $result);
    }

    // ========================================
    // Header Management Tests
    // ========================================

    /**
     * Tests getHeader() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getHeader
     * @return void
     */
    public function testGetHeader()
    {
        $_SERVER['HTTP_AUTHORIZATION'] = 'Bearer token123';
        
        $result = RequestHelper::getHeader('Authorization');
        
        $this->assertEquals('Bearer token123', $result);
    }

    /**
     * Tests getHeader() method with default value.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getHeader
     * @return void
     */
    public function testGetHeaderWithDefault()
    {
        $result = RequestHelper::getHeader('Non-Existent', 'default-value');
        
        $this->assertEquals('default-value', $result);
    }

    /**
     * Tests hasHeader() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::hasHeader
     * @return void
     */
    public function testHasHeader()
    {
        $_SERVER['HTTP_CUSTOM_HEADER'] = 'value';
        
        $result = RequestHelper::hasHeader('Custom-Header');
        
        $this->assertTrue($result);
    }

    /**
     * Tests getAllHeaders() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getAllHeaders
     * @return void
     */
    public function testGetAllHeaders()
    {
        $_SERVER['HTTP_HOST'] = 'example.com';
        $_SERVER['HTTP_USER_AGENT'] = 'TestAgent';
        
        $result = RequestHelper::getAllHeaders();
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Host', $result);
        $this->assertEquals('example.com', $result['Host']);
    }

    // ========================================
    // Security and Validation Tests
    // ========================================

    /**
     * Tests isLegitimate() method with legitimate request.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isLegitimate
     * @return void
     */
    public function testIsLegitimateWithLegitimateRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)';
        
        $result = RequestHelper::isLegitimate();
        
        $this->assertTrue($result);
    }

    /**
     * Tests isLegitimate() method with suspicious request.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isLegitimate
     * @return void
     */
    public function testIsLegitimateWithSuspiciousRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['HTTP_USER_AGENT'] = '<script>alert("xss")</script>';
        
        $result = RequestHelper::isLegitimate();
        
        $this->assertFalse($result);
    }

    /**
     * Tests getRequestTime() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getRequestTime
     * @return void
     */
    public function testGetRequestTime()
    {
        $time = microtime(true);
        $_SERVER['REQUEST_TIME_FLOAT'] = $time;
        
        $result = RequestHelper::getRequestTime();
        
        $this->assertEquals($time, $result);
    }

    /**
     * Tests isWithinRateLimit() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::isWithinRateLimit
     * @return void
     */
    public function testIsWithinRateLimit()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REMOTE_ADDR'] = '192.168.1.100';
        
        $result = RequestHelper::isWithinRateLimit(10, 60, 'test-identifier');
        
        $this->assertTrue($result);
    }

    // ========================================
    // Utility Methods Tests
    // ========================================

    /**
     * Tests getRequestInfo() method in CLI mode.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getRequestInfo
     * @return void
     */
    public function testGetRequestInfoInCliMode()
    {
        $this->setupCliEnvironment();
        
        $result = RequestHelper::getRequestInfo();
        
        $this->assertIsArray($result);
        $this->assertEquals('CLI', $result['environment']);
        $this->assertNull($result['method']);
    }

    /**
     * Tests getRequestInfo() method in web mode.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getRequestInfo
     * @return void
     */
    public function testGetRequestInfoInWebMode()
    {
        $this->setupWebEnvironment();
        $_SERVER['REQUEST_URI'] = '/test';
        $_SERVER['HTTP_HOST'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '80';
        
        $result = RequestHelper::getRequestInfo();
        
        $this->assertIsArray($result);
        $this->assertEquals('Web', $result['environment']);
        $this->assertEquals('GET', $result['method']);
        $this->assertEquals('/test', $result['uri']);
        $this->assertEquals('example.com', $result['host']);
    }

    /**
     * Tests setTrustedProxyHeaders() and getTrustedProxyHeaders() methods.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::setTrustedProxyHeaders
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getTrustedProxyHeaders
     * @return void
     */
    public function testTrustedProxyHeadersManagement()
    {
        $headers = ['HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP'];
        
        RequestHelper::setTrustedProxyHeaders($headers);
        $result = RequestHelper::getTrustedProxyHeaders();
        
        $this->assertEquals($headers, $result);
    }

    /**
     * Tests constants are properly defined.
     *
     * @test
     * @return void
     */
    public function testConstants()
    {
        $this->assertEquals('GET', RequestHelper::METHOD_GET);
        $this->assertEquals('POST', RequestHelper::METHOD_POST);
        $this->assertEquals('application/json', RequestHelper::CONTENT_TYPE_JSON);
        $this->assertEquals('application/xml', RequestHelper::CONTENT_TYPE_XML);
    }

    /**
     * Tests edge cases and error handling.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\RequestHelper::getAcceptedLanguages
     * @return void
     */
    public function testEdgeCases()
    {
        // Test with empty Accept-Language header
        unset($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        
        $result = RequestHelper::getAcceptedLanguages();
        
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * Tests performance with multiple method calls.
     *
     * @test
     * @return void
     */
    public function testPerformanceWithMultipleCalls()
    {
        $this->setupWebEnvironment();
        $_SERVER['HTTP_HOST'] = 'example.com';
        $_SERVER['HTTP_USER_AGENT'] = 'TestAgent';
        
        // Multiple calls should be consistent and performant
        for ($i = 0; $i < 10; $i++) {
            $method = RequestHelper::getMethod();
            $host = RequestHelper::getHost();
            $userAgent = RequestHelper::getUserAgent();
            $isSecure = RequestHelper::isSecure();
            
            $this->assertEquals('GET', $method);
            $this->assertEquals('example.com', $host);
            $this->assertEquals('TestAgent', $userAgent);
            $this->assertIsBool($isSecure);
        }
    }
} 