<?php

namespace Tests\Http;

use PHPUnit\Framework\TestCase;
use AndreasGlaser\Helpers\Http\UrlHelper;

/**
 * UrlHelperTest provides unit tests for the UrlHelper class.
 *
 * This class tests URL generation and manipulation methods:
 * - Protocol, host, and port string generation
 * - Query string building with parameter merging
 * - Current URL and URI retrieval
 * - CLI mode handling and HTTPS detection
 * - URL encoding and parameter handling
 * 
 * Each method is tested with various server configurations, CLI mode,
 * HTTPS scenarios, custom ports, and edge cases.
 */
class UrlHelperTest extends TestCase
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

    // ========================================
    // Tests for protocolHostPort() method
    // ========================================

    /**
     * Tests protocolHostPort() method in CLI mode.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::protocolHostPort
     * @return void
     */
    public function testProtocolHostPortInCliMode()
    {
        // Simulate CLI mode by unsetting REQUEST_METHOD
        unset($_SERVER['REQUEST_METHOD']);

        $result = UrlHelper::protocolHostPort();

        $this->assertNull($result);
    }

    /**
     * Tests protocolHostPort() method with HTTP on standard port.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::protocolHostPort
     * @return void
     */
    public function testProtocolHostPortHttpStandardPort()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '80';
        unset($_SERVER['HTTPS']);

        $result = UrlHelper::protocolHostPort();

        $this->assertEquals('http://example.com', $result);
    }

    /**
     * Tests protocolHostPort() method with HTTPS on standard port.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::protocolHostPort
     * @return void
     */
    public function testProtocolHostPortHttpsStandardPort()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '443';
        $_SERVER['HTTPS'] = 'on';

        $result = UrlHelper::protocolHostPort();

        $this->assertEquals('https://example.com', $result);
    }

    /**
     * Tests protocolHostPort() method with HTTP on custom port.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::protocolHostPort
     * @return void
     */
    public function testProtocolHostPortHttpCustomPort()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '8080';
        unset($_SERVER['HTTPS']);

        $result = UrlHelper::protocolHostPort();

        $this->assertEquals('http://example.com:8080', $result);
    }

    /**
     * Tests protocolHostPort() method with HTTPS on custom port.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::protocolHostPort
     * @return void
     */
    public function testProtocolHostPortHttpsCustomPort()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'secure.example.com';
        $_SERVER['SERVER_PORT'] = '8443';
        $_SERVER['HTTPS'] = 'on';

        $result = UrlHelper::protocolHostPort();

        $this->assertEquals('https://secure.example.com:8443', $result);
    }

    /**
     * Tests protocolHostPort() method with HTTPS set to 'off'.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::protocolHostPort
     * @return void
     */
    public function testProtocolHostPortHttpsOff()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['HTTPS'] = 'off';

        $result = UrlHelper::protocolHostPort();

        $this->assertEquals('http://example.com', $result);
    }

    /**
     * Tests protocolHostPort() method with different server names.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::protocolHostPort
     * @return void
     */
    public function testProtocolHostPortDifferentServerNames()
    {
        $servers = [
            'localhost',
            '127.0.0.1',
            'api.example.com',
            'sub.domain.example.org'
        ];

        foreach ($servers as $serverName) {
            $_SERVER['REQUEST_METHOD'] = 'GET';
            $_SERVER['SERVER_NAME'] = $serverName;
            $_SERVER['SERVER_PORT'] = '80';
            unset($_SERVER['HTTPS']);

            $result = UrlHelper::protocolHostPort();

            $this->assertEquals("http://{$serverName}", $result);
        }
    }

    // ========================================
    // Tests for query() method
    // ========================================

    /**
     * Tests query() method with null parameters and no GET variables.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::query
     * @return void
     */
    public function testQueryWithNullParametersNoGet()
    {
        $_GET = [];

        $result = UrlHelper::query(null);

        $this->assertNull($result);
    }

    /**
     * Tests query() method with empty array parameters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::query
     * @return void
     */
    public function testQueryWithEmptyArray()
    {
        $_GET = [];

        $result = UrlHelper::query([]);

        $this->assertNull($result);
    }

    /**
     * Tests query() method with simple parameters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::query
     * @return void
     */
    public function testQueryWithSimpleParameters()
    {
        $_GET = [];

        $parameters = ['name' => 'John', 'age' => '30'];
        $result = UrlHelper::query($parameters);

        $this->assertEquals('?name=John&age=30', $result);
    }

    /**
     * Tests query() method with special characters in parameters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::query
     * @return void
     */
    public function testQueryWithSpecialCharacters()
    {
        $_GET = [];

        $parameters = ['search' => 'hello world', 'filter' => 'type=user&status=active'];
        $result = UrlHelper::query($parameters);

        $this->assertStringContainsString('?', $result);
        $this->assertStringContainsString('search=hello+world', $result);
        $this->assertStringContainsString('filter=type%3Duser%26status%3Dactive', $result);
    }

    /**
     * Tests query() method with array parameters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::query
     * @return void
     */
    public function testQueryWithArrayParameters()
    {
        $_GET = [];

        $parameters = ['tags' => ['php', 'testing', 'web']];
        $result = UrlHelper::query($parameters);

        $this->assertStringContainsString('?', $result);
        $this->assertStringContainsString('tags%5B0%5D=php', $result);
        $this->assertStringContainsString('tags%5B1%5D=testing', $result);
        $this->assertStringContainsString('tags%5B2%5D=web', $result);
    }

    /**
     * Tests query() method with merging GET variables.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::query
     * @return void
     */
    public function testQueryWithMergingGetVariables()
    {
        $_GET = ['existing' => 'value', 'page' => '1'];

        $parameters = ['new' => 'parameter', 'page' => '2'];
        $result = UrlHelper::query($parameters, true);

        $this->assertStringContainsString('?', $result);
        $this->assertStringContainsString('existing=value', $result);
        $this->assertStringContainsString('new=parameter', $result);
        $this->assertStringContainsString('page=2', $result); // Should be overridden
    }

    /**
     * Tests query() method without merging GET variables.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::query
     * @return void
     */
    public function testQueryWithoutMergingGetVariables()
    {
        $_GET = ['existing' => 'value', 'page' => '1'];

        $parameters = ['new' => 'parameter'];
        $result = UrlHelper::query($parameters, false);

        $this->assertEquals('?new=parameter', $result);
        $this->assertStringNotContainsString('existing', $result);
        $this->assertStringNotContainsString('page', $result);
    }

    /**
     * Tests query() method with null parameters and existing GET variables.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::query
     * @return void
     */
    public function testQueryWithNullParametersWithExistingGet()
    {
        $_GET = ['user' => 'admin', 'section' => 'settings'];

        $result = UrlHelper::query(null, true);

        $this->assertStringContainsString('?', $result);
        $this->assertStringContainsString('user=admin', $result);
        $this->assertStringContainsString('section=settings', $result);
    }

    /**
     * Tests query() method with nested array parameters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::query
     * @return void
     */
    public function testQueryWithNestedArrayParameters()
    {
        $_GET = [];

        $parameters = [
            'user' => [
                'name' => 'John',
                'profile' => ['age' => 30, 'city' => 'New York']
            ]
        ];
        $result = UrlHelper::query($parameters);

        $this->assertStringContainsString('?', $result);
        $this->assertStringContainsString('user%5Bname%5D=John', $result);
        $this->assertStringContainsString('user%5Bprofile%5D%5Bage%5D=30', $result);
    }

    // ========================================
    // Tests for currentUrl() method
    // ========================================

    /**
     * Tests currentUrl() method in CLI mode.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUrl
     * @return void
     */
    public function testCurrentUrlInCliMode()
    {
        unset($_SERVER['REQUEST_METHOD']);

        $result = UrlHelper::currentUrl();

        $this->assertNull($result);
    }

    /**
     * Tests currentUrl() method with basic setup.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUrl
     * @return void
     */
    public function testCurrentUrlBasicSetup()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['REQUEST_URI'] = '/path/to/page';
        unset($_SERVER['HTTPS']);

        $result = UrlHelper::currentUrl();

        $this->assertEquals('http://example.com/path/to/page', $result);
    }

    /**
     * Tests currentUrl() method with query string included.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUrl
     * @return void
     */
    public function testCurrentUrlWithQueryString()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['REQUEST_URI'] = '/search?q=test&page=1';
        unset($_SERVER['HTTPS']);

        $result = UrlHelper::currentUrl(true);

        $this->assertEquals('http://example.com/search?q=test&page=1', $result);
    }

    /**
     * Tests currentUrl() method without query string.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUrl
     * @return void
     */
    public function testCurrentUrlWithoutQueryString()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['REQUEST_URI'] = '/search?q=test&page=1';
        unset($_SERVER['HTTPS']);

        $result = UrlHelper::currentUrl(false);

        $this->assertEquals('http://example.com/search', $result);
    }

    /**
     * Tests currentUrl() method with URL encoding.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUrl
     * @return void
     */
    public function testCurrentUrlWithEncoding()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['REQUEST_URI'] = '/path with spaces';
        unset($_SERVER['HTTPS']);

        $result = UrlHelper::currentUrl(true, true);

        // When URL encoding is enabled, the entire URL gets encoded
        $this->assertStringContainsString('http%3A%2F%2F', $result);
        $this->assertStringContainsString('%252Fpath%2Bwith%2Bspaces', $result);
    }

    /**
     * Tests currentUrl() method with HTTPS and custom port.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUrl
     * @return void
     */
    public function testCurrentUrlHttpsCustomPort()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'secure.example.com';
        $_SERVER['SERVER_PORT'] = '8443';
        $_SERVER['REQUEST_URI'] = '/admin/dashboard';
        $_SERVER['HTTPS'] = 'on';

        $result = UrlHelper::currentUrl();

        $this->assertEquals('https://secure.example.com:8443/admin/dashboard', $result);
    }

    // ========================================
    // Tests for currentUri() method
    // ========================================

    /**
     * Tests currentUri() method in CLI mode.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUri
     * @return void
     */
    public function testCurrentUriInCliMode()
    {
        unset($_SERVER['REQUEST_METHOD']);

        $result = UrlHelper::currentUri();

        $this->assertNull($result);
    }

    /**
     * Tests currentUri() method with basic URI.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUri
     * @return void
     */
    public function testCurrentUriBasic()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/path/to/resource';

        $result = UrlHelper::currentUri();

        $this->assertEquals('/path/to/resource', $result);
    }

    /**
     * Tests currentUri() method with query parameters included.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUri
     * @return void
     */
    public function testCurrentUriWithQueryParameters()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/api/users?limit=10&offset=20';

        $result = UrlHelper::currentUri(true);

        $this->assertEquals('/api/users?limit=10&offset=20', $result);
    }

    /**
     * Tests currentUri() method without query parameters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUri
     * @return void
     */
    public function testCurrentUriWithoutQueryParameters()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/api/users?limit=10&offset=20';

        $result = UrlHelper::currentUri(false);

        $this->assertEquals('/api/users', $result);
    }

    /**
     * Tests currentUri() method with encoding.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUri
     * @return void
     */
    public function testCurrentUriWithEncoding()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/path/with spaces/and?special=chars';

        $result = UrlHelper::currentUri(true, true);

        $this->assertStringContainsString('%2F', $result); // encoded slash
        $this->assertStringContainsString('with+spaces', $result);
    }

    /**
     * Tests currentUri() method without encoding.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUri
     * @return void
     */
    public function testCurrentUriWithoutEncoding()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/path/with spaces/and?special=chars';

        $result = UrlHelper::currentUri(true, false);

        $this->assertEquals('/path/with spaces/and?special=chars', $result);
    }

    /**
     * Tests currentUri() method with root URI.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUri
     * @return void
     */
    public function testCurrentUriRoot()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';

        $result = UrlHelper::currentUri();

        $this->assertEquals('/', $result);
    }

    /**
     * Tests currentUri() method with complex query string.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUri
     * @return void
     */
    public function testCurrentUriComplexQueryString()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/search?q=php+testing&categories[]=web&categories[]=backend&sort=date';

        $resultWithQuery = UrlHelper::currentUri(true);
        $resultWithoutQuery = UrlHelper::currentUri(false);

        $this->assertEquals('/search?q=php+testing&categories[]=web&categories[]=backend&sort=date', $resultWithQuery);
        $this->assertEquals('/search', $resultWithoutQuery);
    }

    /**
     * Tests currentUri() method with fragment in URI.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUri
     * @return void
     */
    public function testCurrentUriWithFragment()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/page?section=intro#top';

        $result = UrlHelper::currentUri();

        $this->assertEquals('/page?section=intro#top', $result);
    }

    // ========================================
    // Integration and Edge Case Tests
    // ========================================

    /**
     * Tests integration between protocolHostPort() and currentUri().
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::protocolHostPort
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUri
     * @return void
     */
    public function testIntegrationProtocolHostPortAndCurrentUri()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['SERVER_NAME'] = 'api.example.com';
        $_SERVER['SERVER_PORT'] = '443';
        $_SERVER['REQUEST_URI'] = '/v1/users/123?include=profile';
        $_SERVER['HTTPS'] = 'on';

        $protocolHostPort = UrlHelper::protocolHostPort();
        $currentUri = UrlHelper::currentUri();

        $this->assertEquals('https://api.example.com', $protocolHostPort);
        $this->assertEquals('/v1/users/123?include=profile', $currentUri);

        $fullUrl = $protocolHostPort . $currentUri;
        $this->assertEquals('https://api.example.com/v1/users/123?include=profile', $fullUrl);
    }

    /**
     * Tests query() method with boolean and numeric values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::query
     * @return void
     */
    public function testQueryWithBooleanAndNumericValues()
    {
        $_GET = [];

        $parameters = [
            'active' => true,
            'count' => 42,
            'price' => 19.99,
            'disabled' => false
        ];

        $result = UrlHelper::query($parameters);

        $this->assertStringContainsString('active=1', $result);
        $this->assertStringContainsString('count=42', $result);
        $this->assertStringContainsString('price=19.99', $result);
        $this->assertStringContainsString('disabled=', $result); // false becomes empty
    }

    /**
     * Tests edge case with empty string values in query.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::query
     * @return void
     */
    public function testQueryWithEmptyStringValues()
    {
        $_GET = [];

        $parameters = [
            'empty' => '',
            'null' => null,
            'zero' => '0',
            'normal' => 'value'
        ];

        $result = UrlHelper::query($parameters);

        $this->assertStringContainsString('?', $result);
        $this->assertStringContainsString('empty=', $result);
        $this->assertStringContainsString('zero=0', $result);
        $this->assertStringContainsString('normal=value', $result);
    }

    /**
     * Tests currentUrl() method return type consistency.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUrl
     * @return void
     */
    public function testCurrentUrlReturnTypeConsistency()
    {
        // Test CLI mode
        unset($_SERVER['REQUEST_METHOD']);
        $cliResult = UrlHelper::currentUrl();
        $this->assertNull($cliResult);

        // Test web mode
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['REQUEST_URI'] = '/test';
        unset($_SERVER['HTTPS']);

        $webResult = UrlHelper::currentUrl();
        $this->assertIsString($webResult);
    }

    /**
     * Tests performance with multiple consecutive calls.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::protocolHostPort
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::query
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUrl
     * @covers \AndreasGlaser\Helpers\Http\UrlHelper::currentUri
     * @return void
     */
    public function testPerformanceWithMultipleCalls()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['REQUEST_URI'] = '/test?param=value';
        unset($_SERVER['HTTPS']);
        $_GET = ['existing' => 'value'];

        // Multiple calls should be consistent
        for ($i = 0; $i < 5; $i++) {
            $protocolHostPort = UrlHelper::protocolHostPort();
            $query = UrlHelper::query(['new' => 'param']);
            $currentUrl = UrlHelper::currentUrl();
            $currentUri = UrlHelper::currentUri();

            $this->assertEquals('http://example.com', $protocolHostPort);
            $this->assertStringContainsString('existing=value', $query);
            $this->assertEquals('http://example.com/test?param=value', $currentUrl);
            $this->assertEquals('/test?param=value', $currentUri);
        }
    }
} 