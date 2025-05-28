<?php

namespace AndreasGlaser\Helpers\Validate;

/**
 * NetworkHelper provides methods for validating network-related data formats.
 * 
 * This class contains methods for validating and analyzing:
 * - IPv4 addresses
 * - IPv6 addresses
 * - IP address ranges and CIDR
 * - Private and reserved IP ranges
 * - Port numbers
 * - Domain names
 * - MAC addresses
 * - CIDR notation
 * - Subnet masks
 * - DNS records
 * - Socket operations
 */
class NetworkHelper
{
    /**
     * Common ports for well-known services
     */
    public const COMMON_PORTS = [
        'http' => 80,
        'https' => 443,
        'ftp' => 21,
        'ssh' => 22,
        'telnet' => 23,
        'smtp' => 25,
        'dns' => 53,
        'pop3' => 110,
        'imap' => 143,
        'ldap' => 389,
        'https-alt' => 8443,
    ];

    /**
     * DNS record types
     */
    public const DNS_TYPES = [
        'A' => DNS_A,
        'AAAA' => DNS_AAAA,
        'CNAME' => DNS_CNAME,
        'MX' => DNS_MX,
        'NS' => DNS_NS,
        'PTR' => DNS_PTR,
        'SOA' => DNS_SOA,
        'TXT' => DNS_TXT,
    ];

    /**
     * Validates an IPv4 address.
     *
     * @param string $ip The IP address to validate
     * @return bool True if the IP is a valid IPv4 address
     */
    public static function isValidIPv4(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    /**
     * Validates an IPv6 address.
     *
     * @param string $ip The IP address to validate
     * @return bool True if the IP is a valid IPv6 address
     */
    public static function isValidIPv6(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    /**
     * Validates an IP address (either IPv4 or IPv6).
     *
     * @param string $ip The IP address to validate
     * @param bool $allowPrivate Whether to allow private IP ranges (default: true)
     * @param bool $allowReserved Whether to allow reserved IP ranges (default: true)
     * @return bool True if the IP is valid
     */
    public static function isValidIP(string $ip, bool $allowPrivate = true, bool $allowReserved = true): bool
    {
        $flags = 0;
        if (!$allowPrivate) {
            $flags |= FILTER_FLAG_NO_PRIV_RANGE;
        }
        if (!$allowReserved) {
            $flags |= FILTER_FLAG_NO_RES_RANGE;
        }

        // First check if it's a valid IP at all
        if (filter_var($ip, FILTER_VALIDATE_IP, $flags) === false) {
            return false;
        }

        // Additional check for IPv6 link-local addresses when private IPs are not allowed
        if (!$allowPrivate && self::isValidIPv6($ip)) {
            // Check if it's a link-local address (fe80::/10)
            $normalized = inet_pton($ip);
            if ($normalized !== false) {
                // Check if the first 10 bits match fe80::/10
                $firstByte = ord($normalized[0]);
                $secondByte = ord($normalized[1]);
                if ($firstByte === 0xfe && ($secondByte & 0xc0) === 0x80) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Validates a port number.
     * 
     * Valid port numbers are between 1 and 65535.
     * System ports: 1-1023
     * User ports: 1024-49151
     * Dynamic/private ports: 49152-65535
     *
     * @param int $port The port number to validate
     * @param bool $allowSystemPorts Whether to allow system ports (1-1023)
     * @param bool $allowUserPorts Whether to allow user ports (1024-49151)
     * @param bool $allowDynamicPorts Whether to allow dynamic/private ports (49152-65535)
     * @return bool True if the port is valid
     */
    public static function isValidPort(
        int $port,
        bool $allowSystemPorts = true,
        bool $allowUserPorts = true,
        bool $allowDynamicPorts = true
    ): bool {
        if ($port < 1 || $port > 65535) {
            return false;
        }

        if ($port <= 1023 && !$allowSystemPorts) {
            return false;
        }

        if ($port >= 1024 && $port <= 49151 && !$allowUserPorts) {
            return false;
        }

        if ($port >= 49152 && !$allowDynamicPorts) {
            return false;
        }

        return true;
    }

    /**
     * Validates a domain name.
     * 
     * Rules:
     * - Length between 1 and 253 characters
     * - Each label (part between dots) between 1 and 63 characters
     * - Only alphanumeric characters and hyphens (but not at start/end of label)
     * - At least one dot (unless allowSingleLabel is true)
     * 
     * @param string $domain The domain name to validate
     * @param bool $allowSingleLabel Whether to allow single-label domains (default: false)
     * @param bool $allowPunycode Whether to allow Punycode domains (default: true)
     * @return bool True if the domain is valid
     */
    public static function isValidDomain(string $domain, bool $allowSingleLabel = false, bool $allowPunycode = true): bool
    {
        // Check total length
        if (strlen($domain) > 253 || strlen($domain) < 1) {
            return false;
        }

        // Convert Punycode if needed
        if ($allowPunycode && str_contains($domain, 'xn--')) {
            if (!function_exists('idn_to_ascii')) {
                throw new \RuntimeException('The Intl extension is required for Punycode support.');
            }
            $domain = idn_to_ascii($domain, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
            if ($domain === false) {
                return false;
            }
        }

        // Split into labels
        $labels = explode('.', $domain);

        // Check if single label is allowed
        if (!$allowSingleLabel && count($labels) < 2) {
            return false;
        }

        // Validate each label
        foreach ($labels as $label) {
            // Check label length
            if (strlen($label) > 63 || strlen($label) < 1) {
                return false;
            }

            // Check characters and position of hyphens
            if (!preg_match('/^[a-zA-Z0-9]([a-zA-Z0-9-]*[a-zA-Z0-9])?$/', $label)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validates a MAC address.
     * 
     * Supports various formats:
     * - 00:11:22:33:44:55
     * - 00-11-22-33-44-55
     * - 001122334455
     * 
     * @param string $mac The MAC address to validate
     * @param bool $allowColonFormat Whether to allow colon format (default: true)
     * @param bool $allowHyphenFormat Whether to allow hyphen format (default: true)
     * @param bool $allowBareFormat Whether to allow bare format (default: true)
     * @return bool True if the MAC address is valid
     */
    public static function isValidMac(
        string $mac,
        bool $allowColonFormat = true,
        bool $allowHyphenFormat = true,
        bool $allowBareFormat = true
    ): bool {
        $mac = strtolower($mac);

        if ($allowColonFormat && preg_match('/^([0-9a-f]{2}:){5}[0-9a-f]{2}$/', $mac)) {
            return true;
        }

        if ($allowHyphenFormat && preg_match('/^([0-9a-f]{2}-){5}[0-9a-f]{2}$/', $mac)) {
            return true;
        }

        if ($allowBareFormat && preg_match('/^[0-9a-f]{12}$/', $mac)) {
            return true;
        }

        return false;
    }

    /**
     * Validates a CIDR notation.
     * 
     * Examples:
     * - 192.168.1.0/24
     * - 2001:db8::/32
     *
     * @param string $cidr The CIDR notation to validate
     * @return bool True if the CIDR notation is valid
     */
    public static function isValidCidr(string $cidr): bool
    {
        if (!str_contains($cidr, '/')) {
            return false;
        }

        [$ip, $prefix] = explode('/', $cidr, 2);

        // Validate prefix
        if (!is_numeric($prefix)) {
            return false;
        }

        // Check if it's IPv4
        if (self::isValidIPv4($ip)) {
            return $prefix >= 0 && $prefix <= 32;
        }

        // Check if it's IPv6
        if (self::isValidIPv6($ip)) {
            return $prefix >= 0 && $prefix <= 128;
        }

        return false;
    }

    /**
     * Validates a subnet mask.
     * 
     * Examples:
     * - 255.255.255.0
     * - 255.255.0.0
     *
     * @param string $mask The subnet mask to validate
     * @return bool True if the subnet mask is valid
     */
    public static function isValidSubnetMask(string $mask): bool
    {
        if (!self::isValidIPv4($mask)) {
            return false;
        }

        $parts = array_map('intval', explode('.', $mask));
        $binary = sprintf('%08b%08b%08b%08b', $parts[0], $parts[1], $parts[2], $parts[3]);

        // Valid subnet masks must have continuous 1s followed by continuous 0s
        return preg_match('/^1*0*$/', $binary) === 1;
    }

    /**
     * Gets the common port number for a service.
     *
     * @param string $service The service name (e.g., 'http', 'https', 'ftp')
     * @return int|null The port number, or null if not found
     */
    public static function getCommonPort(string $service): ?int
    {
        $service = strtolower($service);
        return self::COMMON_PORTS[$service] ?? null;
    }

    /**
     * Get DNS records for a domain.
     *
     * @param string $domain The domain name to query
     * @param string $type The record type (A, AAAA, MX, etc.) or 'ALL' for all records
     * @return array DNS records
     * @throws \InvalidArgumentException If domain is invalid
     */
    public static function getDnsRecords(string $domain, string $type = 'ALL'): array
    {
        if (!self::isValidDomain($domain)) {
            throw new \InvalidArgumentException('Invalid domain name');
        }

        $type = strtoupper($type);
        if ($type === 'ALL') {
            return dns_get_record($domain);
        }

        if (!isset(self::DNS_TYPES[$type])) {
            throw new \InvalidArgumentException('Invalid DNS record type');
        }

        return dns_get_record($domain, self::DNS_TYPES[$type]);
    }

    /**
     * Check if a domain has valid MX records.
     *
     * @param string $domain The domain to check
     * @return bool True if the domain has valid MX records
     */
    public static function isValidMxRecord(string $domain): bool
    {
        return getmxrr($domain, $hosts);
    }

    /**
     * Get the reverse DNS (PTR) record for an IP address.
     *
     * @param string $ip The IP address to lookup
     * @return string|null The hostname or null if not found
     * @throws \InvalidArgumentException If IP is invalid
     */
    public static function getReverseDns(string $ip): ?string
    {
        if (!self::isValidIP($ip)) {
            throw new \InvalidArgumentException('Invalid IP address');
        }

        $hostname = gethostbyaddr($ip);
        return ($hostname !== $ip) ? $hostname : null;
    }

    /**
     * Check if a domain has a valid SPF record.
     *
     * @param string $domain The domain to check
     * @return bool True if the domain has a valid SPF record
     */
    public static function hasValidSpfRecord(string $domain): bool
    {
        try {
            $records = self::getDnsRecords($domain, 'TXT');
            foreach ($records as $record) {
                if (isset($record['txt']) && str_starts_with($record['txt'], 'v=spf1')) {
                    return true;
                }
            }
            return false;
        } catch (\InvalidArgumentException $e) {
            return false;
        }
    }

    /**
     * Check if a domain has a valid DKIM record for a selector.
     *
     * @param string $domain The domain to check
     * @param string $selector The DKIM selector
     * @return bool True if the domain has a valid DKIM record
     */
    public static function hasDkimRecord(string $domain, string $selector): bool
    {
        $dkimDomain = $selector . '._domainkey.' . $domain;
        try {
            $records = self::getDnsRecords($dkimDomain, 'TXT');
            foreach ($records as $record) {
                if (isset($record['txt']) && str_contains($record['txt'], 'v=DKIM1')) {
                    return true;
                }
            }
            return false;
        } catch (\InvalidArgumentException $e) {
            return false;
        }
    }

    /**
     * Check if a port is open on a host.
     *
     * @param string $host The host to check
     * @param int $port The port to check
     * @param float $timeout Timeout in seconds
     * @return bool True if the port is open
     * @throws \InvalidArgumentException If port is invalid
     */
    public static function isPortOpen(string $host, int $port, float $timeout = 2.0): bool
    {
        if (!self::isValidPort($port)) {
            throw new \InvalidArgumentException('Invalid port number');
        }

        // Try to resolve hostname first
        if (!filter_var($host, FILTER_VALIDATE_IP)) {
            $ip = gethostbyname($host);
            if ($ip === $host) {
                return false; // Could not resolve hostname
            }
            $host = $ip;
        }

        $socket = @fsockopen($host, $port, $errno, $errstr, $timeout);
        if ($socket === false) {
            return false;
        }

        fclose($socket);
        return true;
    }

    /**
     * Scan multiple ports on a host.
     *
     * @param string $host The host to scan
     * @param array $ports Array of ports to scan
     * @param float $timeout Timeout in seconds for each port
     * @return array Array of open ports
     */
    public static function getOpenPorts(string $host, array $ports, float $timeout = 1.0): array
    {
        $openPorts = [];
        foreach ($ports as $port) {
            if (self::isPortOpen($host, $port, $timeout)) {
                $openPorts[] = $port;
            }
        }
        return $openPorts;
    }

    /**
     * Get the service name for a port number.
     *
     * @param int $port The port number
     * @return string|null The service name or null if not found
     */
    public static function getServiceByPort(int $port): ?string
    {
        $service = array_search($port, self::COMMON_PORTS, true);
        return $service !== false ? $service : null;
    }
} 