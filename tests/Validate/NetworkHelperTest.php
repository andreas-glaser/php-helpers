<?php

namespace AndreasGlaser\Helpers\Tests\Validate;

use AndreasGlaser\Helpers\Validate\NetworkHelper;
use PHPUnit\Framework\TestCase;

class NetworkHelperTest extends TestCase
{
    public function testIsValidIPv4(): void
    {
        // Valid IPv4 addresses
        $this->assertTrue(NetworkHelper::isValidIPv4('192.168.1.1'));
        $this->assertTrue(NetworkHelper::isValidIPv4('127.0.0.1'));
        $this->assertTrue(NetworkHelper::isValidIPv4('0.0.0.0'));
        $this->assertTrue(NetworkHelper::isValidIPv4('255.255.255.255'));
        $this->assertTrue(NetworkHelper::isValidIPv4('8.8.8.8'));

        // Invalid IPv4 addresses
        $this->assertFalse(NetworkHelper::isValidIPv4(''));
        $this->assertFalse(NetworkHelper::isValidIPv4('256.1.2.3'));
        $this->assertFalse(NetworkHelper::isValidIPv4('1.2.3.256'));
        $this->assertFalse(NetworkHelper::isValidIPv4('1.2.3'));
        $this->assertFalse(NetworkHelper::isValidIPv4('1.2.3.4.5'));
        $this->assertFalse(NetworkHelper::isValidIPv4('192.168.001.1'));
    }

    public function testIsValidIPv6(): void
    {
        // Valid IPv6 addresses
        $this->assertTrue(NetworkHelper::isValidIPv6('2001:0db8:85a3:0000:0000:8a2e:0370:7334'));
        $this->assertTrue(NetworkHelper::isValidIPv6('2001:db8:85a3:0:0:8a2e:370:7334'));
        $this->assertTrue(NetworkHelper::isValidIPv6('2001:db8:85a3::8a2e:370:7334'));
        $this->assertTrue(NetworkHelper::isValidIPv6('::1'));
        $this->assertTrue(NetworkHelper::isValidIPv6('fe80::'));

        // Invalid IPv6 addresses
        $this->assertFalse(NetworkHelper::isValidIPv6(''));
        $this->assertFalse(NetworkHelper::isValidIPv6('2001:0db8:85a3:0000:0000:8a2e:0370:7334:'));
        $this->assertFalse(NetworkHelper::isValidIPv6('::::::'));
        $this->assertFalse(NetworkHelper::isValidIPv6('1200::AB00:1234::2552:7777:1313'));
        $this->assertFalse(NetworkHelper::isValidIPv6('1:2:3:4:5:6:7:8:9'));
    }

    public function testIsValidIP(): void
    {
        // Valid IP addresses (both v4 and v6)
        $this->assertTrue(NetworkHelper::isValidIP('192.168.1.1'));
        $this->assertTrue(NetworkHelper::isValidIP('2001:0db8:85a3:0000:0000:8a2e:0370:7334'));
        
        // Test private ranges
        $this->assertTrue(NetworkHelper::isValidIP('192.168.1.1', true));
        $this->assertFalse(NetworkHelper::isValidIP('192.168.1.1', false));
        $this->assertTrue(NetworkHelper::isValidIP('fe80::1', true));
        $this->assertFalse(NetworkHelper::isValidIP('fe80::1', false));

        // Test reserved ranges
        $this->assertTrue(NetworkHelper::isValidIP('0.0.0.0', true, true));
        $this->assertFalse(NetworkHelper::isValidIP('0.0.0.0', true, false));

        // Invalid IP addresses
        $this->assertFalse(NetworkHelper::isValidIP(''));
        $this->assertFalse(NetworkHelper::isValidIP('not an ip'));
        $this->assertFalse(NetworkHelper::isValidIP('256.256.256.256'));
        $this->assertFalse(NetworkHelper::isValidIP('2001:0db8:85a3:0000:0000:8a2e:0370:7334:'));
    }

    public function testIsValidPort(): void
    {
        // Valid ports
        $this->assertTrue(NetworkHelper::isValidPort(80));  // HTTP
        $this->assertTrue(NetworkHelper::isValidPort(443)); // HTTPS
        $this->assertTrue(NetworkHelper::isValidPort(8080)); // Alternative HTTP
        $this->assertTrue(NetworkHelper::isValidPort(1024)); // First user port
        $this->assertTrue(NetworkHelper::isValidPort(49151)); // Last user port
        $this->assertTrue(NetworkHelper::isValidPort(49152)); // First dynamic port
        $this->assertTrue(NetworkHelper::isValidPort(65535)); // Last valid port

        // Invalid ports
        $this->assertFalse(NetworkHelper::isValidPort(0));
        $this->assertFalse(NetworkHelper::isValidPort(65536));
        $this->assertFalse(NetworkHelper::isValidPort(-1));

        // Test port ranges
        $this->assertFalse(NetworkHelper::isValidPort(80, false)); // System port not allowed
        $this->assertFalse(NetworkHelper::isValidPort(8080, true, false)); // User port not allowed
        $this->assertFalse(NetworkHelper::isValidPort(50000, true, true, false)); // Dynamic port not allowed
    }

    public function testIsValidDomain(): void
    {
        // Valid domains
        $this->assertTrue(NetworkHelper::isValidDomain('example.com'));
        $this->assertTrue(NetworkHelper::isValidDomain('sub.example.com'));
        $this->assertTrue(NetworkHelper::isValidDomain('example-domain.com'));
        $this->assertTrue(NetworkHelper::isValidDomain('xn--bcher-kva.com')); // bücher.com in Punycode
        $this->assertTrue(NetworkHelper::isValidDomain('localhost', true)); // Single label allowed

        // Invalid domains
        $this->assertFalse(NetworkHelper::isValidDomain(''));
        $this->assertFalse(NetworkHelper::isValidDomain('localhost')); // Single label not allowed by default
        $this->assertFalse(NetworkHelper::isValidDomain('-example.com')); // Starts with hyphen
        $this->assertFalse(NetworkHelper::isValidDomain('example-.com')); // Ends with hyphen
        $this->assertFalse(NetworkHelper::isValidDomain('exam ple.com')); // Contains space
        $this->assertFalse(NetworkHelper::isValidDomain(str_repeat('a', 254) . '.com')); // Too long
    }

    public function testIsValidMac(): void
    {
        // Valid MAC addresses
        $this->assertTrue(NetworkHelper::isValidMac('00:11:22:33:44:55')); // Colon format
        $this->assertTrue(NetworkHelper::isValidMac('00-11-22-33-44-55')); // Hyphen format
        $this->assertTrue(NetworkHelper::isValidMac('001122334455')); // Bare format
        $this->assertTrue(NetworkHelper::isValidMac('AA:BB:CC:DD:EE:FF')); // Uppercase
        $this->assertTrue(NetworkHelper::isValidMac('aa:bb:cc:dd:ee:ff')); // Lowercase

        // Invalid MAC addresses
        $this->assertFalse(NetworkHelper::isValidMac(''));
        $this->assertFalse(NetworkHelper::isValidMac('00:11:22:33:44')); // Too short
        $this->assertFalse(NetworkHelper::isValidMac('00:11:22:33:44:55:66')); // Too long
        $this->assertFalse(NetworkHelper::isValidMac('GG:HH:II:JJ:KK:LL')); // Invalid characters
        $this->assertFalse(NetworkHelper::isValidMac('00:11:22:33:44:55', false, true, true)); // Only hyphen and bare format allowed
        $this->assertFalse(NetworkHelper::isValidMac('00-11-22-33-44-55', true, false, true)); // Only colon and bare format allowed
    }

    public function testIsValidCidr(): void
    {
        // Valid CIDR notations
        $this->assertTrue(NetworkHelper::isValidCidr('192.168.1.0/24'));
        $this->assertTrue(NetworkHelper::isValidCidr('10.0.0.0/8'));
        $this->assertTrue(NetworkHelper::isValidCidr('2001:db8::/32'));
        $this->assertTrue(NetworkHelper::isValidCidr('::1/128'));

        // Invalid CIDR notations
        $this->assertFalse(NetworkHelper::isValidCidr(''));
        $this->assertFalse(NetworkHelper::isValidCidr('192.168.1.0')); // Missing prefix
        $this->assertFalse(NetworkHelper::isValidCidr('192.168.1.0/33')); // Invalid IPv4 prefix
        $this->assertFalse(NetworkHelper::isValidCidr('2001:db8::/129')); // Invalid IPv6 prefix
        $this->assertFalse(NetworkHelper::isValidCidr('256.256.256.256/24')); // Invalid IP
        $this->assertFalse(NetworkHelper::isValidCidr('192.168.1.0/abc')); // Invalid prefix format
    }

    public function testIsValidSubnetMask(): void
    {
        // Valid subnet masks
        $this->assertTrue(NetworkHelper::isValidSubnetMask('255.255.255.0')); // /24
        $this->assertTrue(NetworkHelper::isValidSubnetMask('255.255.0.0')); // /16
        $this->assertTrue(NetworkHelper::isValidSubnetMask('255.0.0.0')); // /8
        $this->assertTrue(NetworkHelper::isValidSubnetMask('255.255.255.252')); // /30
        $this->assertTrue(NetworkHelper::isValidSubnetMask('255.255.255.255')); // /32

        // Invalid subnet masks
        $this->assertFalse(NetworkHelper::isValidSubnetMask(''));
        $this->assertFalse(NetworkHelper::isValidSubnetMask('256.255.255.0')); // Invalid octet
        $this->assertFalse(NetworkHelper::isValidSubnetMask('255.255.255.1')); // Non-continuous mask
        $this->assertFalse(NetworkHelper::isValidSubnetMask('255.0.255.0')); // Non-continuous mask
        $this->assertFalse(NetworkHelper::isValidSubnetMask('0.255.255.0')); // Non-continuous mask
    }

    public function testGetCommonPort(): void
    {
        // Test common ports
        $this->assertEquals(80, NetworkHelper::getCommonPort('http'));
        $this->assertEquals(443, NetworkHelper::getCommonPort('https'));
        $this->assertEquals(22, NetworkHelper::getCommonPort('ssh'));
        $this->assertEquals(21, NetworkHelper::getCommonPort('ftp'));

        // Test case insensitivity
        $this->assertEquals(80, NetworkHelper::getCommonPort('HTTP'));
        $this->assertEquals(443, NetworkHelper::getCommonPort('HTTPS'));

        // Test unknown service
        $this->assertNull(NetworkHelper::getCommonPort('nonexistent'));
        $this->assertNull(NetworkHelper::getCommonPort(''));
    }

    public function testGetDnsRecords(): void
    {
        // Test with valid domain
        $records = NetworkHelper::getDnsRecords('google.com', 'A');
        $this->assertIsArray($records);
        $this->assertNotEmpty($records);
        $this->assertArrayHasKey('type', $records[0]);
        $this->assertEquals('A', $records[0]['type']);

        // Test with invalid domain type
        $this->expectException(\InvalidArgumentException::class);
        NetworkHelper::getDnsRecords('google.com', 'INVALID');
    }

    public function testIsValidMxRecord(): void
    {
        // Test with domain that should have MX records
        $this->assertTrue(NetworkHelper::isValidMxRecord('google.com'));

        // Test with domain that shouldn't have MX records
        $this->assertFalse(NetworkHelper::isValidMxRecord('invalid-domain-that-does-not-exist.com'));
    }

    public function testGetReverseDns(): void
    {
        // Test with Google's DNS server
        $hostname = NetworkHelper::getReverseDns('8.8.8.8');
        $this->assertNotNull($hostname);
        $this->assertIsString($hostname);

        // Test with invalid IP
        $this->expectException(\InvalidArgumentException::class);
        NetworkHelper::getReverseDns('invalid-ip');
    }

    public function testHasValidSpfRecord(): void
    {
        // Test with domain that should have SPF
        $this->assertTrue(NetworkHelper::hasValidSpfRecord('google.com'));

        // Test with domain that shouldn't have SPF
        $this->assertFalse(NetworkHelper::hasValidSpfRecord('invalid-domain-that-does-not-exist.com'));
    }

    public function testHasDkimRecord(): void
    {
        // Test with known DKIM selector and domain
        $this->assertIsBool(NetworkHelper::hasDkimRecord('google.com', 'default'));

        // Test with invalid domain
        $this->assertFalse(NetworkHelper::hasDkimRecord('invalid-domain-that-does-not-exist.com', 'default'));
    }

    public function testIsPortOpen(): void
    {
        // Test with common HTTP port on google.com
        $this->assertTrue(NetworkHelper::isPortOpen('google.com', 80));
        $this->assertTrue(NetworkHelper::isPortOpen('google.com', 443));

        // Test with likely closed port
        $this->assertFalse(NetworkHelper::isPortOpen('google.com', 54321));

        // Test with invalid port
        $this->expectException(\InvalidArgumentException::class);
        NetworkHelper::isPortOpen('google.com', 0);
    }

    public function testGetOpenPorts(): void
    {
        // Test with common ports on google.com
        $ports = [80, 443, 54321];
        $openPorts = NetworkHelper::getOpenPorts('google.com', $ports);
        $this->assertIsArray($openPorts);
        $this->assertContains(80, $openPorts);
        $this->assertContains(443, $openPorts);
        $this->assertNotContains(54321, $openPorts);
    }

    public function testGetServiceByPort(): void
    {
        // Test common ports
        $this->assertEquals('http', NetworkHelper::getServiceByPort(80));
        $this->assertEquals('https', NetworkHelper::getServiceByPort(443));
        $this->assertEquals('ssh', NetworkHelper::getServiceByPort(22));

        // Test unknown port
        $this->assertNull(NetworkHelper::getServiceByPort(54321));
    }
} 