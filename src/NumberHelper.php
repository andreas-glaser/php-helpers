<?php

namespace AndreasGlaser\Helpers;

/**
 * NumberHelper provides comprehensive utility methods for working with numbers.
 * 
 * This class contains methods for:
 * - Converting numbers to ordinal indicators (1st, 2nd, 3rd, etc.)
 * - Number formatting with thousands separators and decimal places
 * - Number conversion between different bases and formats
 * - Mathematical calculations and utilities
 * - Currency and file size formatting
 * - Number validation and parsing
 */
class NumberHelper
{
    /**
     * Converts a number to its ordinal indicator suffix.
     * 
     * This method handles special cases:
     * - Numbers ending in 11, 12, 13 use 'th'
     * - Numbers ending in 1 use 'st'
     * - Numbers ending in 2 use 'nd'
     * - Numbers ending in 3 use 'rd'
     * - All other numbers use 'th'
     *
     * @param int|float $number The number to convert
     *
     * @return string The ordinal indicator suffix ('st', 'nd', 'rd', or 'th')
     */
    public static function ordinal($number): string
    {
        if ($number % 100 > 10 && $number % 100 < 14) {
            return 'th';
        }

        switch ($number % 10) {
            case 1:
                return 'st';
            case 2:
                return 'nd';
            case 3:
                return 'rd';
            default:
                return 'th';
        }
    }

    /**
     * Formats a number with thousands separators and decimal places.
     * 
     * @param float|int $number The number to format
     * @param int $decimals Number of decimal places (default: 2)
     * @param string $decimalSeparator Decimal separator (default: '.')
     * @param string $thousandsSeparator Thousands separator (default: ',')
     * 
     * @return string The formatted number
     * 
     * @example NumberHelper::format(1234.56) // Returns "1,234.56"
     * @example NumberHelper::format(1234.56, 1, '.', ' ') // Returns "1 234.6"
     */
    public static function format($number, int $decimals = 2, string $decimalSeparator = '.', string $thousandsSeparator = ','): string
    {
        return number_format((float)$number, $decimals, $decimalSeparator, $thousandsSeparator);
    }

    /**
     * Converts a number to its percentage representation.
     * 
     * @param float|int $number The number to convert (e.g., 0.25 or 25)
     * @param bool $isDecimal Whether the input is already a decimal (0.25) or percentage (25)
     * @param int $decimals Number of decimal places in result
     * 
     * @return string The percentage string with % symbol
     * 
     * @example NumberHelper::percentage(0.25, true) // Returns "25.00%"
     * @example NumberHelper::percentage(25, false) // Returns "25.00%"
     */
    public static function percentage($number, bool $isDecimal = true, int $decimals = 2): string
    {
        $value = $isDecimal ? $number * 100 : $number;
        return self::format($value, $decimals) . '%';
    }

    /**
     * Calculates percentage of a value from a total.
     * 
     * @param float|int $value The value to calculate percentage for
     * @param float|int $total The total value
     * @param int $decimals Number of decimal places in result
     * 
     * @return float The percentage as a decimal (e.g., 0.25 for 25%)
     * 
     * @throws \InvalidArgumentException If total is zero
     * 
     * @example NumberHelper::percentageOf(25, 100) // Returns 0.25
     */
    public static function percentageOf($value, $total, int $decimals = 4): float
    {
        if ($total == 0) {
            throw new \InvalidArgumentException('Total cannot be zero for percentage calculation.');
        }
        
        return round($value / $total, $decimals);
    }

    /**
     * Rounds a number to the specified precision and method.
     * 
     * @param float|int $number The number to round
     * @param int $precision The number of decimal places
     * @param int $mode The rounding mode (PHP_ROUND_* constants)
     * 
     * @return float The rounded number
     * 
     * @example NumberHelper::round(1.235, 2) // Returns 1.24
     * @example NumberHelper::round(1.235, 2, PHP_ROUND_DOWN) // Returns 1.23
     */
    public static function round($number, int $precision = 0, int $mode = PHP_ROUND_HALF_UP): float
    {
        return round((float)$number, $precision, $mode);
    }

    /**
     * Clamps a number between minimum and maximum values.
     * 
     * @param float|int $number The number to clamp
     * @param float|int $min The minimum value
     * @param float|int $max The maximum value
     * 
     * @return float|int The clamped number
     * 
     * @throws \InvalidArgumentException If min > max
     * 
     * @example NumberHelper::clamp(15, 10, 20) // Returns 15
     * @example NumberHelper::clamp(5, 10, 20) // Returns 10
     * @example NumberHelper::clamp(25, 10, 20) // Returns 20
     */
    public static function clamp($number, $min, $max)
    {
        if ($min > $max) {
            throw new \InvalidArgumentException('Minimum value cannot be greater than maximum value.');
        }
        
        return max($min, min($max, $number));
    }

    /**
     * Converts bytes to human readable file size format.
     * 
     * @param int|float $bytes The number of bytes
     * @param int $decimals Number of decimal places
     * @param bool $binary Whether to use binary (1024) or decimal (1000) units
     * 
     * @return string The formatted file size
     * 
     * @example NumberHelper::fileSize(1024) // Returns "1.00 KB"
     * @example NumberHelper::fileSize(1000, 2, false) // Returns "1.00 KB" (decimal)
     */
    public static function fileSize($bytes, int $decimals = 2, bool $binary = true): string
    {
        $base = $binary ? 1024 : 1000;
        $units = $binary 
            ? ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
            : ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        
        if ($bytes == 0) {
            return '0 B';
        }
        
        $exponent = floor(log($bytes) / log($base));
        $value = $bytes / pow($base, $exponent);
        
        return self::format($value, $decimals) . ' ' . $units[$exponent];
    }

    /**
     * Converts a number to Roman numerals.
     * 
     * @param int $number The number to convert (1-3999)
     * 
     * @return string The Roman numeral representation
     * 
     * @throws \InvalidArgumentException If number is outside valid range
     * 
     * @example NumberHelper::toRoman(1984) // Returns "MCMLXXXIV"
     */
    public static function toRoman(int $number): string
    {
        if ($number < 1 || $number > 3999) {
            throw new \InvalidArgumentException('Number must be between 1 and 3999 for Roman numeral conversion.');
        }
        
        $values = [1000, 900, 500, 400, 100, 90, 50, 40, 10, 9, 5, 4, 1];
        $numerals = ['M', 'CM', 'D', 'CD', 'C', 'XC', 'L', 'XL', 'X', 'IX', 'V', 'IV', 'I'];
        
        $result = '';
        for ($i = 0; $i < count($values); $i++) {
            while ($number >= $values[$i]) {
                $result .= $numerals[$i];
                $number -= $values[$i];
            }
        }
        
        return $result;
    }

    /**
     * Converts Roman numerals back to a number.
     * 
     * @param string $roman The Roman numeral string
     * 
     * @return int The numeric value
     * 
     * @throws \InvalidArgumentException If Roman numeral is invalid
     * 
     * @example NumberHelper::fromRoman("MCMLXXXIV") // Returns 1984
     */
    public static function fromRoman(string $roman): int
    {
        $roman = strtoupper(trim($roman));
        $values = ['M' => 1000, 'D' => 500, 'C' => 100, 'L' => 50, 'X' => 10, 'V' => 5, 'I' => 1];
        
        $result = 0;
        $prev = 0;
        
        for ($i = strlen($roman) - 1; $i >= 0; $i--) {
            $char = $roman[$i];
            if (!isset($values[$char])) {
                throw new \InvalidArgumentException("Invalid Roman numeral character: {$char}");
            }
            
            $current = $values[$char];
            if ($current < $prev) {
                $result -= $current;
            } else {
                $result += $current;
            }
            $prev = $current;
        }
        
        return $result;
    }

    /**
     * Converts a number to different number base.
     * 
     * @param int|string $number The number to convert
     * @param int $fromBase The current base (2-36)
     * @param int $toBase The target base (2-36)
     * 
     * @return string The number in the target base
     * 
     * @throws \InvalidArgumentException If base is invalid
     * 
     * @example NumberHelper::changeBase(255, 10, 16) // Returns "ff"
     * @example NumberHelper::changeBase("ff", 16, 10) // Returns "255"
     */
    public static function changeBase($number, int $fromBase, int $toBase): string
    {
        if ($fromBase < 2 || $fromBase > 36 || $toBase < 2 || $toBase > 36) {
            throw new \InvalidArgumentException('Base must be between 2 and 36.');
        }
        
        // Convert to decimal first, then to target base
        $decimal = base_convert($number, $fromBase, 10);
        return base_convert($decimal, 10, $toBase);
    }

    /**
     * Checks if a number is within a specified range (inclusive).
     * 
     * @param float|int $number The number to check
     * @param float|int $min The minimum value (inclusive)
     * @param float|int $max The maximum value (inclusive)
     * 
     * @return bool True if number is within range
     * 
     * @example NumberHelper::inRange(15, 10, 20) // Returns true
     * @example NumberHelper::inRange(5, 10, 20) // Returns false
     */
    public static function inRange($number, $min, $max): bool
    {
        return $number >= $min && $number <= $max;
    }

    /**
     * Checks if a number is even.
     * 
     * @param int $number The number to check
     * 
     * @return bool True if number is even
     * 
     * @example NumberHelper::isEven(4) // Returns true
     * @example NumberHelper::isEven(5) // Returns false
     */
    public static function isEven(int $number): bool
    {
        return $number % 2 === 0;
    }

    /**
     * Checks if a number is odd.
     * 
     * @param int $number The number to check
     * 
     * @return bool True if number is odd
     * 
     * @example NumberHelper::isOdd(5) // Returns true
     * @example NumberHelper::isOdd(4) // Returns false
     */
    public static function isOdd(int $number): bool
    {
        return $number % 2 !== 0;
    }

    /**
     * Checks if a number is prime.
     * 
     * @param int $number The number to check
     * 
     * @return bool True if number is prime
     * 
     * @example NumberHelper::isPrime(17) // Returns true
     * @example NumberHelper::isPrime(18) // Returns false
     */
    public static function isPrime(int $number): bool
    {
        if ($number < 2) {
            return false;
        }
        
        if ($number === 2) {
            return true;
        }
        
        if ($number % 2 === 0) {
            return false;
        }
        
        for ($i = 3; $i <= sqrt($number); $i += 2) {
            if ($number % $i === 0) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Calculates the absolute difference between two numbers.
     * 
     * @param float|int $a First number
     * @param float|int $b Second number
     * 
     * @return float|int The absolute difference
     * 
     * @example NumberHelper::difference(10, 3) // Returns 7
     * @example NumberHelper::difference(3, 10) // Returns 7
     */
    public static function difference($a, $b)
    {
        return abs($a - $b);
    }

    /**
     * Calculates the average of an array of numbers.
     * 
     * @param array $numbers Array of numbers
     * 
     * @return float The average value
     * 
     * @throws \InvalidArgumentException If array is empty or contains non-numeric values
     * 
     * @example NumberHelper::average([1, 2, 3, 4, 5]) // Returns 3.0
     */
    public static function average(array $numbers): float
    {
        if (empty($numbers)) {
            throw new \InvalidArgumentException('Cannot calculate average of empty array.');
        }
        
        foreach ($numbers as $number) {
            if (!is_numeric($number)) {
                throw new \InvalidArgumentException('All array elements must be numeric.');
            }
        }
        
        return array_sum($numbers) / count($numbers);
    }

    /**
     * Finds the median value in an array of numbers.
     * 
     * @param array $numbers Array of numbers
     * 
     * @return float The median value
     * 
     * @throws \InvalidArgumentException If array is empty or contains non-numeric values
     * 
     * @example NumberHelper::median([1, 2, 3, 4, 5]) // Returns 3.0
     * @example NumberHelper::median([1, 2, 3, 4]) // Returns 2.5
     */
    public static function median(array $numbers): float
    {
        if (empty($numbers)) {
            throw new \InvalidArgumentException('Cannot calculate median of empty array.');
        }
        
        foreach ($numbers as $number) {
            if (!is_numeric($number)) {
                throw new \InvalidArgumentException('All array elements must be numeric.');
            }
        }
        
        sort($numbers);
        $count = count($numbers);
        $middle = floor($count / 2);
        
        if ($count % 2 === 0) {
            return ($numbers[$middle - 1] + $numbers[$middle]) / 2;
        } else {
            return $numbers[$middle];
        }
    }

    /**
     * Parses a formatted number string back to a numeric value.
     * 
     * @param string $formattedNumber The formatted number string
     * @param string $decimalSeparator The decimal separator used
     * @param string $thousandsSeparator The thousands separator used
     * 
     * @return float The parsed numeric value
     * 
     * @example NumberHelper::parse("1,234.56") // Returns 1234.56
     * @example NumberHelper::parse("1 234,56", ",", " ") // Returns 1234.56
     */
    public static function parse(string $formattedNumber, string $decimalSeparator = '.', string $thousandsSeparator = ','): float
    {
        // Remove thousands separators
        $cleaned = str_replace($thousandsSeparator, '', $formattedNumber);
        
        // Convert decimal separator to period if needed
        if ($decimalSeparator !== '.') {
            $cleaned = str_replace($decimalSeparator, '.', $cleaned);
        }
        
        return (float)$cleaned;
    }
}
