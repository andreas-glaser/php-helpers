<?php

namespace AndreasGlaser\Helpers;

/**
 * RandomHelper provides comprehensive utility methods for generating random values.
 * 
 * This class contains methods for:
 * - Generating random boolean values
 * - Creating cryptographically secure unique identifiers
 * - Generating random numbers with various constraints
 * - Creating random strings with customizable character sets
 * - Selecting random elements from arrays
 * - Generating random colors and UUIDs
 * - Creating secure passwords and tokens
 * - Shuffling arrays and strings
 */
class RandomHelper
{
    /**
     * Character sets for various random string generation
     */
    public const CHARSET_NUMERIC = '0123456789';
    public const CHARSET_ALPHA_LOWER = 'abcdefghijklmnopqrstuvwxyz';
    public const CHARSET_ALPHA_UPPER = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public const CHARSET_ALPHA = self::CHARSET_ALPHA_LOWER . self::CHARSET_ALPHA_UPPER;
    public const CHARSET_ALPHANUMERIC = self::CHARSET_ALPHA . self::CHARSET_NUMERIC;
    public const CHARSET_SPECIAL = '!@#$%^&*()_+-=[]{}|;:,.<>?';
    public const CHARSET_PASSWORD = self::CHARSET_ALPHANUMERIC . self::CHARSET_SPECIAL;
    public const CHARSET_HEX = '0123456789abcdef';
    public const CHARSET_BASE64 = self::CHARSET_ALPHANUMERIC . '+/';

    /**
     * Generates a random boolean value.
     * 
     * This method uses PHP's rand() function to generate either true or false
     * with equal probability (50% chance each).
     *
     * @return bool A random boolean value
     */
    public static function trueFalse(): bool
    {
        return 1 === \rand(0, 1);
    }

    /**
     * Generates a cryptographically secure unique identifier.
     * 
     * This method:
     * - Uses random_bytes() if available (PHP 7+)
     * - Falls back to openssl_random_pseudo_bytes() if available
     * - Throws an exception if no secure random function is available
     * - Returns a 13-character hex string (optionally prefixed)
     *
     * @param string $prefix Optional prefix to prepend to the unique identifier
     *
     * @return string A cryptographically secure unique identifier
     *
     * @throws \Exception If no cryptographically secure random function is available
     * 
     * @source https://www.php.net/manual/en/function.uniqid.php#120123
     */
    public static function uniqid(string $prefix = ''): string
    {
        if (true === \function_exists('random_bytes')) {
            $bytes = \random_bytes(7);
        } elseif (true === \function_exists('openssl_random_pseudo_bytes')) {
            $bytes = \openssl_random_pseudo_bytes(7);
        } else {
            throw new \Exception('No cryptographically secure random function available');
        }

        return $prefix . \mb_substr(\bin2hex($bytes), 0, 13);
    }

    /**
     * Generates a random integer within the specified range (inclusive).
     * 
     * @param int $min The minimum value (inclusive)
     * @param int $max The maximum value (inclusive)
     * 
     * @return int A random integer between min and max
     * 
     * @throws \InvalidArgumentException If min is greater than max
     * 
     * @example RandomHelper::int(1, 10) // Returns random integer between 1 and 10
     */
    public static function int(int $min = 0, int $max = \PHP_INT_MAX): int
    {
        if ($min > $max) {
            throw new \InvalidArgumentException('Minimum value cannot be greater than maximum value.');
        }
        
        return \rand($min, $max);
    }

    /**
     * Generates a random float within the specified range.
     * 
     * @param float $min The minimum value (inclusive)
     * @param float $max The maximum value (inclusive)
     * @param int $precision The number of decimal places
     * 
     * @return float A random float between min and max
     * 
     * @throws \InvalidArgumentException If min is greater than max
     * 
     * @example RandomHelper::float(0.0, 1.0, 2) // Returns random float like 0.73
     */
    public static function float(float $min = 0.0, float $max = 1.0, int $precision = 2): float
    {
        if ($min > $max) {
            throw new \InvalidArgumentException('Minimum value cannot be greater than maximum value.');
        }
        
        $random = $min + (\rand() / \getrandmax()) * ($max - $min);
        return \round($random, $precision);
    }

    /**
     * Generates a random string with specified length and character set.
     * 
     * @param int $length The length of the string to generate
     * @param string $charset The character set to use (defaults to alphanumeric)
     * 
     * @return string A random string
     * 
     * @throws \InvalidArgumentException If length is less than 1 or charset is empty
     * 
     * @example RandomHelper::string(8) // Returns random string like "aB3kL9pQ"
     * @example RandomHelper::string(6, RandomHelper::CHARSET_NUMERIC) // Returns "847293"
     */
    public static function string(int $length, string $charset = self::CHARSET_ALPHANUMERIC): string
    {
        if ($length < 1) {
            throw new \InvalidArgumentException('Length must be at least 1.');
        }
        
        if (empty($charset)) {
            throw new \InvalidArgumentException('Character set cannot be empty.');
        }
        
        $result = '';
        $charsetLength = \strlen($charset);
        
        for ($i = 0; $i < $length; $i++) {
            $result .= $charset[\rand(0, $charsetLength - 1)];
        }
        
        return $result;
    }

    /**
     * Generates a cryptographically secure random string.
     * 
     * @param int $length The length of the string to generate
     * @param string $charset The character set to use
     * 
     * @return string A cryptographically secure random string
     * 
     * @throws \InvalidArgumentException If length is less than 1 or charset is empty
     * @throws \Exception If no secure random function is available
     * 
     * @example RandomHelper::secureString(16) // Returns secure random string
     */
    public static function secureString(int $length, string $charset = self::CHARSET_ALPHANUMERIC): string
    {
        if ($length < 1) {
            throw new \InvalidArgumentException('Length must be at least 1.');
        }
        
        if (empty($charset)) {
            throw new \InvalidArgumentException('Character set cannot be empty.');
        }
        
        if (!\function_exists('random_bytes')) {
            throw new \Exception('random_bytes function is not available for secure string generation.');
        }
        
        $result = '';
        $charsetLength = \strlen($charset);
        $bytes = \random_bytes($length);
        
        for ($i = 0; $i < $length; $i++) {
            $result .= $charset[\ord($bytes[$i]) % $charsetLength];
        }
        
        return $result;
    }

    /**
     * Generates a random password with specified criteria.
     * 
     * @param int $length The length of the password
     * @param bool $includeUppercase Include uppercase letters
     * @param bool $includeLowercase Include lowercase letters
     * @param bool $includeNumbers Include numbers
     * @param bool $includeSpecial Include special characters
     * @param string $excludeChars Characters to exclude from generation
     * 
     * @return string A random password
     * 
     * @throws \InvalidArgumentException If length is less than 1 or no character types selected
     * 
     * @example RandomHelper::password(12) // Returns secure 12-character password
     */
    public static function password(
        int $length = 12,
        bool $includeUppercase = true,
        bool $includeLowercase = true,
        bool $includeNumbers = true,
        bool $includeSpecial = true,
        string $excludeChars = ''
    ): string {
        if ($length < 1) {
            throw new \InvalidArgumentException('Password length must be at least 1.');
        }
        
        $charset = '';
        
        if ($includeUppercase) {
            $charset .= self::CHARSET_ALPHA_UPPER;
        }
        if ($includeLowercase) {
            $charset .= self::CHARSET_ALPHA_LOWER;
        }
        if ($includeNumbers) {
            $charset .= self::CHARSET_NUMERIC;
        }
        if ($includeSpecial) {
            $charset .= self::CHARSET_SPECIAL;
        }
        
        if (empty($charset)) {
            throw new \InvalidArgumentException('At least one character type must be included.');
        }
        
        // Remove excluded characters
        if (!empty($excludeChars)) {
            $charset = \str_replace(\str_split($excludeChars), '', $charset);
        }
        
        return self::secureString($length, $charset);
    }

    /**
     * Selects a random element from an array.
     * 
     * @param array $array The array to select from
     * 
     * @return mixed A random element from the array
     * 
     * @throws \InvalidArgumentException If array is empty
     * 
     * @example RandomHelper::arrayElement(['apple', 'banana', 'orange']) // Returns random fruit
     */
    public static function arrayElement(array $array)
    {
        if (empty($array)) {
            throw new \InvalidArgumentException('Array cannot be empty.');
        }
        
        $keys = \array_keys($array);
        $randomKey = $keys[\rand(0, \count($keys) - 1)];
        
        return $array[$randomKey];
    }

    /**
     * Selects multiple random elements from an array without replacement.
     * 
     * @param array $array The array to select from
     * @param int $count The number of elements to select
     * 
     * @return array An array of random elements
     * 
     * @throws \InvalidArgumentException If array is empty or count is invalid
     * 
     * @example RandomHelper::arrayElements(['a', 'b', 'c', 'd'], 2) // Returns ['c', 'a']
     */
    public static function arrayElements(array $array, int $count): array
    {
        if (empty($array)) {
            throw new \InvalidArgumentException('Array cannot be empty.');
        }
        
        if ($count < 1) {
            throw new \InvalidArgumentException('Count must be at least 1.');
        }
        
        if ($count > \count($array)) {
            throw new \InvalidArgumentException('Count cannot be greater than array size.');
        }
        
        $keys = \array_keys($array);
        \shuffle($keys);
        $selectedKeys = \array_slice($keys, 0, $count);
        
        $result = [];
        foreach ($selectedKeys as $key) {
            $result[] = $array[$key];
        }
        
        return $result;
    }

    /**
     * Shuffles an array and returns it (does not modify original).
     * 
     * @param array $array The array to shuffle
     * 
     * @return array The shuffled array
     * 
     * @example RandomHelper::shuffle(['a', 'b', 'c']) // Returns shuffled array like ['c', 'a', 'b']
     */
    public static function shuffle(array $array): array
    {
        $shuffled = $array;
        \shuffle($shuffled);
        return $shuffled;
    }

    /**
     * Generates a random hexadecimal color code.
     * 
     * @param bool $includeHash Whether to include the # prefix
     * 
     * @return string A random hex color code
     * 
     * @example RandomHelper::hexColor() // Returns "#a3f2d1"
     * @example RandomHelper::hexColor(false) // Returns "a3f2d1"
     */
    public static function hexColor(bool $includeHash = true): string
    {
        $color = self::string(6, self::CHARSET_HEX);
        return $includeHash ? '#' . $color : $color;
    }

    /**
     * Generates a random RGB color array.
     * 
     * @return array An array with 'r', 'g', 'b' keys and values 0-255
     * 
     * @example RandomHelper::rgbColor() // Returns ['r' => 163, 'g' => 242, 'b' => 209]
     */
    public static function rgbColor(): array
    {
        return [
            'r' => self::int(0, 255),
            'g' => self::int(0, 255),
            'b' => self::int(0, 255),
        ];
    }

    /**
     * Generates a Version 4 UUID (random).
     * 
     * @return string A Version 4 UUID
     * 
     * @throws \Exception If no secure random function is available
     * 
     * @example RandomHelper::uuid4() // Returns "f47ac10b-58cc-4372-a567-0e02b2c3d479"
     */
    public static function uuid4(): string
    {
        if (!\function_exists('random_bytes')) {
            throw new \Exception('random_bytes function is not available for UUID generation.');
        }
        
        $data = \random_bytes(16);
        
        // Set version to 0100
        $data[6] = \chr(\ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = \chr(\ord($data[8]) & 0x3f | 0x80);
        
        return \sprintf(
            '%08s-%04s-%04s-%04s-%12s',
            \bin2hex(\substr($data, 0, 4)),
            \bin2hex(\substr($data, 4, 2)),
            \bin2hex(\substr($data, 6, 2)),
            \bin2hex(\substr($data, 8, 2)),
            \bin2hex(\substr($data, 10, 6))
        );
    }

    /**
     * Generates a random token suitable for API keys or session tokens.
     * 
     * @param int $length The length of the token
     * @param bool $urlSafe Whether to use URL-safe characters only
     * 
     * @return string A random token
     * 
     * @throws \InvalidArgumentException If length is less than 1
     * @throws \Exception If no secure random function is available
     * 
     * @example RandomHelper::token(32) // Returns 32-character secure token
     */
    public static function token(int $length = 32, bool $urlSafe = true): string
    {
        if ($length < 1) {
            throw new \InvalidArgumentException('Token length must be at least 1.');
        }
        
        $charset = $urlSafe ? self::CHARSET_ALPHANUMERIC . '-_' : self::CHARSET_BASE64;
        return self::secureString($length, $charset);
    }

    /**
     * Generates a random date between two dates.
     * 
     * @param \DateTime $start The start date
     * @param \DateTime $end The end date
     * @param string $format The format to return the date in
     * 
     * @return string A random date in the specified format
     * 
     * @throws \InvalidArgumentException If start date is after end date
     * 
     * @example RandomHelper::date(new DateTime('2020-01-01'), new DateTime('2023-12-31'))
     */
    public static function date(\DateTime $start, \DateTime $end, string $format = 'Y-m-d'): string
    {
        if ($start > $end) {
            throw new \InvalidArgumentException('Start date cannot be after end date.');
        }
        
        $startTimestamp = $start->getTimestamp();
        $endTimestamp = $end->getTimestamp();
        
        $randomTimestamp = self::int($startTimestamp, $endTimestamp);
        $randomDate = new \DateTime();
        $randomDate->setTimestamp($randomTimestamp);
        
        return $randomDate->format($format);
    }

    /**
     * Generates a weighted random selection from an array.
     * 
     * @param array $weights Associative array where keys are items and values are weights
     * 
     * @return mixed The selected item based on weights
     * 
     * @throws \InvalidArgumentException If weights array is empty or contains invalid weights
     * 
     * @example RandomHelper::weighted(['common' => 70, 'rare' => 20, 'epic' => 10])
     */
    public static function weighted(array $weights)
    {
        if (empty($weights)) {
            throw new \InvalidArgumentException('Weights array cannot be empty.');
        }
        
        $totalWeight = 0;
        foreach ($weights as $weight) {
            if (!\is_numeric($weight) || $weight < 0) {
                throw new \InvalidArgumentException('All weights must be non-negative numbers.');
            }
            $totalWeight += $weight;
        }
        
        if ($totalWeight <= 0) {
            throw new \InvalidArgumentException('Total weight must be greater than 0.');
        }
        
        $random = self::float(0, $totalWeight, 10);
        $currentWeight = 0;
        
        foreach ($weights as $item => $weight) {
            $currentWeight += $weight;
            if ($random <= $currentWeight) {
                return $item;
            }
        }
        
        // Fallback (shouldn't reach here)
        return \array_key_first($weights);
    }

    /**
     * Generates a random MAC address.
     * 
     * @param string $separator The separator to use between octets
     * @param bool $uppercase Whether to use uppercase hex characters
     * 
     * @return string A random MAC address
     * 
     * @example RandomHelper::macAddress() // Returns "a3:f2:d1:8b:4c:7e"
     * @example RandomHelper::macAddress('-', true) // Returns "A3-F2-D1-8B-4C-7E"
     */
    public static function macAddress(string $separator = ':', bool $uppercase = false): string
    {
        $octets = [];
        for ($i = 0; $i < 6; $i++) {
            $octet = self::string(2, self::CHARSET_HEX);
            $octets[] = $uppercase ? \strtoupper($octet) : $octet;
        }
        
        return \implode($separator, $octets);
    }

    /**
     * Generates a random IP address.
     * 
     * @param int $version IP version (4 or 6)
     * @param bool $private Whether to generate private IP ranges
     * 
     * @return string A random IP address
     * 
     * @throws \InvalidArgumentException If version is not 4 or 6
     * 
     * @example RandomHelper::ipAddress() // Returns "192.168.1.45"
     * @example RandomHelper::ipAddress(6) // Returns "2001:db8::1a2b:3c4d:5e6f:7890"
     */
    public static function ipAddress(int $version = 4, bool $private = false): string
    {
        if ($version === 4) {
            if ($private) {
                // Generate private IPv4 ranges
                $ranges = [
                    ['10.0.0.0', '10.255.255.255'],
                    ['172.16.0.0', '172.31.255.255'],
                    ['192.168.0.0', '192.168.255.255'],
                ];
                $range = self::arrayElement($ranges);
                $start = \ip2long($range[0]);
                $end = \ip2long($range[1]);
                return \long2ip(self::int($start, $end));
            } else {
                return self::int(1, 223) . '.' . 
                       self::int(0, 255) . '.' . 
                       self::int(0, 255) . '.' . 
                       self::int(1, 254);
            }
        } elseif ($version === 6) {
            $groups = [];
            for ($i = 0; $i < 8; $i++) {
                $groups[] = self::string(4, self::CHARSET_HEX);
            }
            return \implode(':', $groups);
        } else {
            throw new \InvalidArgumentException('IP version must be 4 or 6.');
        }
    }
}
