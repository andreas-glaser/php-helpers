# PHP Helpers

A comprehensive collection of PHP helper functions and classes to simplify common programming tasks.

## Requirements

- PHP 7.4 or higher
- PHP 8.0 or higher
- ext-mbstring
- ext-json

## Installation

```bash
composer require andreas-glaser/php-helpers
```

## Features

### Array Helper (`ArrayHelper.php`)
A powerful utility class for array manipulation and operations.

#### Key Functions:
- `ArrayHelper::get(array $array, $key, $default = null)`: Get value by key with default fallback
- `ArrayHelper::getByPath(array $array, $path, $throwException = false, $default = null)`: Get value using dot notation path
- `ArrayHelper::setByPath(array $array, $path, $value)`: Set value using dot notation path
- `ArrayHelper::unsetByPath(array $array, string $path)`: Remove value using dot notation path
- `ArrayHelper::existsByPath(array $array, $path)`: Check if path exists
- `ArrayHelper::prepend(array $array, $value, $key = false)`: Add element at array start
- `ArrayHelper::append(array $array, $value, $key = false)`: Add element at array end
- `ArrayHelper::insertBefore(array &$array, $position, array $values)`: Insert values before position
- `ArrayHelper::insertAfter(array &$array, $position, array $values)`: Insert values after position
- `ArrayHelper::getFirstValue(array $array, $default = null)`: Get first array value
- `ArrayHelper::getLastValue(array $array, $default = null)`: Get last array value
- `ArrayHelper::getRandomValue(array $array)`: Get random array value
- `ArrayHelper::removeFirstElement(array $array)`: Remove first element
- `ArrayHelper::removeLastElement(array $array)`: Remove last element
- `ArrayHelper::removeByValue(array $array, $value, $strict = true)`: Remove element by value
- `ArrayHelper::keysCamelToUnderscore(array $array)`: Convert array keys to underscore case
- `ArrayHelper::unsetEmptyValues(array $array, $recursive = false)`: Remove empty values
- `ArrayHelper::isAssoc(array $array)`: Check if array is associative
- `ArrayHelper::merge()`: Merge multiple arrays

### String Helper (`StringHelper.php`)
Comprehensive string manipulation and formatting utilities.

#### Key Functions:
- `StringHelper::is($string, $stringToMatch, $caseSensitive = true)`: Compare strings
- `StringHelper::isOneOf($string, array $stringsToCompare, $caseSensitive = true)`: Check if string matches any in array
- `StringHelper::contains($haystack, $needle, $caseSensitive = true)`: Check if string contains substring
- `StringHelper::startsWith($haystack, $needle, $caseSensitive = true)`: Check if string starts with
- `StringHelper::endsWith($haystack, $needle, $caseSensitive = true)`: Check if string ends with
- `StringHelper::trimMulti($string, array $chars)`: Trim multiple characters
- `StringHelper::camelToUnderscore($string)`: Convert camelCase to snake_case
- `StringHelper::removeLineBreaks($string, $replaceWith = ' ')`: Remove line breaks
- `StringHelper::removeRedundantWhiteSpaces($string)`: Remove extra spaces
- `StringHelper::machineReadable($string)`: Convert to machine-readable format
- `StringHelper::limitWords($str, $limit = 100, $end_char = null)`: Limit string to word count
- `StringHelper::limitChars($str, $limit = 100, $end_char = null)`: Limit string to character count
- `StringHelper::isBlank($string)`: Check if string is blank
- `StringHelper::removeFromStart($string, $stringToRemove)`: Remove prefix
- `StringHelper::removeFromEnd($string, $stringToRemove)`: Remove suffix

### Date Helper (`DateHelper.php`)
Date and time manipulation utilities.

#### Key Functions:
- `DateHelper::format($date, $format)`: Format date
- `DateHelper::isValid($date)`: Validate date
- `DateHelper::isValidFormat($date, $format)`: Validate date format
- `DateHelper::getAge($date)`: Calculate age from date
- `DateHelper::getDaysBetween($date1, $date2)`: Calculate days between dates
- `DateHelper::getMonthsBetween($date1, $date2)`: Calculate months between dates
- `DateHelper::getYearsBetween($date1, $date2)`: Calculate years between dates

### HTML Helper (`HtmlHelper.php`)
HTML generation and manipulation utilities.

#### Key Functions:
- `HtmlHelper::tag($name, $content = null, array $attributes = [])`: Generate HTML tag
- `HtmlHelper::link($url, $text = null, array $attributes = [])`: Generate link
- `HtmlHelper::img($src, array $attributes = [])`: Generate image tag
- `HtmlHelper::script($src, array $attributes = [])`: Generate script tag
- `HtmlHelper::style($href, array $attributes = [])`: Generate style tag
- `HtmlHelper::meta($name, $content, array $attributes = [])`: Generate meta tag
- `HtmlHelper::escape($string)`: Escape HTML special characters

### JSON Helper (`JsonHelper.php`)
JSON encoding and decoding utilities.

#### Key Functions:
- `JsonHelper::encode($value, $options = 0)`: Encode to JSON
- `JsonHelper::decode($json, $assoc = false, $depth = 512)`: Decode from JSON
- `JsonHelper::isValid($json)`: Validate JSON string

### Number Helper (`NumberHelper.php`)
Number formatting and manipulation utilities.

#### Key Functions:
- `NumberHelper::format($number, $decimals = 2)`: Format number
- `NumberHelper::formatCurrency($number, $currency = 'USD')`: Format as currency
- `NumberHelper::formatPercent($number, $decimals = 2)`: Format as percentage
- `NumberHelper::isEven($number)`: Check if number is even
- `NumberHelper::isOdd($number)`: Check if number is odd

### Random Helper (`RandomHelper.php`)
Random value generation utilities.

#### Key Functions:
- `RandomHelper::string($length = 10)`: Generate random string
- `RandomHelper::number($min = 0, $max = 100)`: Generate random number
- `RandomHelper::element(array $array)`: Get random array element
- `RandomHelper::boolean()`: Generate random boolean

### Timer Helper (`TimerHelper.php`)
Time measurement and execution timing utilities.

#### Key Functions:
- `TimerHelper::start()`: Start timer
- `TimerHelper::stop()`: Stop timer
- `TimerHelper::getTime()`: Get elapsed time
- `TimerHelper::getMemory()`: Get memory usage

### Value Helper (`ValueHelper.php`)
Value manipulation and type conversion utilities.

#### Key Functions:
- `ValueHelper::isDateTime($value)`: Check if value is datetime
- `ValueHelper::isJson($value)`: Check if value is JSON
- `ValueHelper::isEmail($value)`: Check if value is email
- `ValueHelper::isUrl($value)`: Check if value is URL
- `ValueHelper::toArray($value)`: Convert to array
- `ValueHelper::toString($value)`: Convert to string

### Counter Helper (`CounterHelper.php`)
Counter implementation for tracking and incrementing values.

#### Key Functions:
- `CounterHelper::increment()`: Increment counter
- `CounterHelper::decrement()`: Decrement counter
- `CounterHelper::getValue()`: Get current value
- `CounterHelper::reset()`: Reset counter

### CSV Helper (`CsvHelper.php`)
CSV file handling and manipulation utilities.

#### Key Functions:
- `CsvHelper::read($file)`: Read CSV file
- `CsvHelper::write($file, array $data)`: Write to CSV file
- `CsvHelper::parse($string)`: Parse CSV string
- `CsvHelper::generate(array $data)`: Generate CSV string

### Email Helper (`EmailHelper.php`)
Email validation and formatting utilities.

#### Key Functions:
- `EmailHelper::isValid($email)`: Validate email address
- `EmailHelper::normalize($email)`: Normalize email address
- `EmailHelper::getDomain($email)`: Get email domain
- `EmailHelper::getLocalPart($email)`: Get email local part

### IO Helper (`IOHelper.php`)
Input/Output utilities for file and stream operations.

#### Key Functions:
- `IOHelper::read($file)`: Read file
- `IOHelper::write($file, $content)`: Write to file
- `IOHelper::append($file, $content)`: Append to file
- `IOHelper::delete($file)`: Delete file
- `IOHelper::exists($file)`: Check if file exists

## Additional Components

### Color
Color manipulation and conversion utilities.

### HTTP
HTTP request and response handling utilities.

### HTML
HTML-specific utilities and helpers.

### Validate
Data validation utilities.

### View
View rendering and template utilities.

### Traits
Reusable traits for common functionality.

### Interfaces
Interface definitions for the library components.

### Exceptions
Custom exception classes for error handling.

## Usage

```php
use AndreasGlaser\Helpers\ArrayHelper;
use AndreasGlaser\Helpers\StringHelper;
use AndreasGlaser\Helpers\DateHelper;

// Array operations
$array = ['a' => 1, 'b' => 2];
$value = ArrayHelper::get($array, 'a', 'default'); // Returns 1
$nestedArray = ['user' => ['profile' => ['name' => 'John']]];
$name = ArrayHelper::getByPath($nestedArray, 'user.profile.name'); // Returns 'John'

// String operations
$string = 'Hello World';
$contains = StringHelper::contains($string, 'World'); // Returns true
$startsWith = StringHelper::startsWith($string, 'Hello'); // Returns true
$underscore = StringHelper::camelToUnderscore('helloWorld'); // Returns 'hello_world'

// Date operations
$date = new DateTime();
$formatted = DateHelper::format($date, 'Y-m-d'); // Returns current date in Y-m-d format
$isValid = DateHelper::isValid('2024-03-20'); // Returns true
```

## Testing

```bash
composer test
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Author

- **Andreas Glaser** - [GitHub](https://github.com/andreas-glaser)

## Support

If you find this library helpful, please consider giving it a star on GitHub!