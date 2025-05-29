# PHP Helpers

A comprehensive collection of PHP helper functions and classes to simplify common programming tasks.

## Requirements

- PHP ^8.2|^8.3|^8.4
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
- `ArrayHelper::getKeyByValue(array $array, $value, $default = null, $strict = true)`: Get first key with matching value
- `ArrayHelper::getByPath(array $array, $path, $throwException = false, $default = null)`: Get value using dot notation path
- `ArrayHelper::setByPath(array $array, $path, $value)`: Set value using dot notation path
- `ArrayHelper::unsetByPath(array $array, string $path)`: Remove value using dot notation path
- `ArrayHelper::existsByPath(array $array, $path)`: Check if path exists
- `ArrayHelper::issetByPath(array $array, $path)`: Check if path is set
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
- `ArrayHelper::keysCamelToUnderscore(array $array)`: Convert camelCase keys to snake_case
- `ArrayHelper::unsetEmptyValues(array $array, $recursive = false)`: Remove empty values
- `ArrayHelper::implodeIgnoreEmpty($glue, array $pieces)`: Join array elements ignoring empty values
- `ArrayHelper::implodeKeys(string $glue, array $array)`: Join array keys with delimiter
- `ArrayHelper::explodeIgnoreEmpty(string $delimiter, string $string)`: Split string ignoring empty values
- `ArrayHelper::valueToUpper(array $array, $recursive = true)`: Convert values to uppercase
- `ArrayHelper::isAssoc(array $array)`: Check if array is associative
- `ArrayHelper::assocIndexesExist(array $arrayToCheck, array $arrayToCompareWith, $throwException = true)`: Check if indexes exist
- `ArrayHelper::replaceValue(array $array, $value, $replacement, $recursively = true, $caseSensitive = true)`: Replace values in array
- `ArrayHelper::merge(array $array1, array $array2)`: Merge arrays with proper handling of numeric keys
- `ArrayHelper::getFirstIndex($array, $default = null)`: Get first array index
- `ArrayHelper::unshiftAssoc($array, $key, $val)`: Add element at start with key
- `ArrayHelper::removeFirstIndex(array $array)`: Remove first array index

### String Helper (`StringHelper.php`)
Comprehensive string manipulation and comparison utilities.

#### Key Functions:
- `StringHelper::is($string, $stringToMatch, $caseSensitive = true)`: Compare strings with case sensitivity option
- `StringHelper::isOneOf($string, array $stringsToCompare, $caseSensitive = true)`: Check if string matches any in array
- `StringHelper::contains($haystack, $needle, $caseSensitive = true, $encoding = 'UTF-8')`: Check if string contains substring
- `StringHelper::startsWith($haystack, $needle, $caseSensitive = true, $encoding = 'UTF-8')`: Check if string starts with prefix
- `StringHelper::endsWith($haystack, $needle, $caseSensitive = true, $encoding = 'UTF-8')`: Check if string ends with suffix
- `StringHelper::trimMulti($string, array $chars)`: Remove multiple characters from both ends
- `StringHelper::lTrimMulti($string, array $chars)`: Remove multiple characters from left end
- `StringHelper::rTrimMulti($string, array $chars)`: Remove multiple characters from right end
- `StringHelper::camelToUnderscore($string)`: Convert camelCase to underscore_case
- `StringHelper::removeLineBreaks($string, $replaceWith = ' ')`: Remove line breaks
- `StringHelper::removeRedundantWhiteSpaces($string)`: Remove redundant whitespace
- `StringHelper::replaceWhiteSpacesWithUnderscores($string)`: Replace spaces with underscores
- `StringHelper::machineReadable($string)`: Convert to machine-readable format
- `StringHelper::append($string, $stringToAppend)`: Append string
- `StringHelper::prepend($string, $stringToPrepend)`: Prepend string
- `StringHelper::removeChar($string, $char)`: Remove single character
- `StringHelper::removeChars($string, array $chars)`: Remove multiple characters
- `StringHelper::explodeAndTrim($delimiter, $string)`: Split string and trim each part
- `StringHelper::replace($subject, array $replacementMap, $caseSensitive = true)`: Replace multiple values
- `StringHelper::limitWords($str, $limit = 100, $end_char = null)`: Limit string to word count
- `StringHelper::limitChars($str, $limit = 100, $end_char = null, $preserve_words = false)`: Limit string to character count
- `StringHelper::getIncrementalId($prefix = '__undefined__')`: Generate sequential ID
- `StringHelper::isBlank($string)`: Check if string is empty or contains only whitespace
- `StringHelper::removeFromStart($string, $stringToRemove, $caseSensitive = true, $encoding = 'UTF-8')`: Remove prefix
- `StringHelper::removeFromEnd($string, $stringToRemove, $caseSensitive = true, $encoding = 'UTF-8')`: Remove suffix
- `StringHelper::linesToArray($string)`: Convert string with line breaks to array
- `StringHelper::__($string, array $params = null)`: String translation helper

### Date Helper (`DateHelper.php`)
Date and time manipulation and validation utilities.

#### Key Functions:
- `DateHelper::isDateTime($date, $format = null)`: Check if value is valid datetime
- `DateHelper::stringToDateTime($string, $timezone = null, $null = null)`: Convert string to DateTime object
- `DateHelper::formatOrNull($dateTime, $format = 'Y-m-d H:i:s', $null = null)`: Format datetime or return null if invalid
- `DateHelper::diffHours($dateTime1, $dateTime2)`: Calculate hour differences between datetimes
- `DateHelper::diffDays($dateTime1, $dateTime2)`: Calculate day differences between datetimes
- `DateHelper::diffMonths($dateTime1, $dateTime2)`: Calculate month differences between datetimes
- `DateHelper::diffYears($dateTime1, $dateTime2)`: Calculate year differences between datetimes

### HTML Helper (`HtmlHelper.php`)
HTML element generation and attribute handling utilities.

#### Key Functions:
- `HtmlHelper::chars($value, $double_encode = true)`: Convert special characters to HTML entities
- `HtmlHelper::entities($value, $double_encode = true)`: Convert all applicable characters to HTML entities
- `HtmlHelper::div($content, $attributesHelper = null)`: Create div element
- `HtmlHelper::p($content, $attributesHelper = null)`: Create paragraph element
- `HtmlHelper::span($content, $attributesHelper = null)`: Create span element
- `HtmlHelper::h1($content, $attributesHelper = null)` through `h6()`: Create heading elements
- `HtmlHelper::a($url, $content, $attributesHelper = null)`: Create anchor element
- `HtmlHelper::image($src, $attributesHelper = null)`: Create image element
- `HtmlHelper::autoParagraph($str, $br = true)`: Convert text to paragraphs

##### Text Formatting Elements:
- `HtmlHelper::strong($content, $attributesHelper = null)`: Create strong (bold) element
- `HtmlHelper::em($content, $attributesHelper = null)`: Create emphasis (italic) element
- `HtmlHelper::code($content, $attributesHelper = null)`: Create code element
- `HtmlHelper::pre($content, $attributesHelper = null)`: Create preformatted text element
- `HtmlHelper::mark($content, $attributesHelper = null)`: Create highlighted text element
- `HtmlHelper::small($content, $attributesHelper = null)`: Create small text element
- `HtmlHelper::sub($content, $attributesHelper = null)`: Create subscript element
- `HtmlHelper::sup($content, $attributesHelper = null)`: Create superscript element

##### Semantic Elements:
- `HtmlHelper::blockquote($content, $attributesHelper = null)`: Create blockquote element
- `HtmlHelper::cite($content, $attributesHelper = null)`: Create citation element
- `HtmlHelper::time($content, $datetime = null, $attributesHelper = null)`: Create time element with optional datetime attribute
- `HtmlHelper::abbr($content, $title = null, $attributesHelper = null)`: Create abbreviation element with optional title

##### Structural Elements:
- `HtmlHelper::article($content, $attributesHelper = null)`: Create article element
- `HtmlHelper::section($content, $attributesHelper = null)`: Create section element
- `HtmlHelper::nav($content, $attributesHelper = null)`: Create navigation element
- `HtmlHelper::aside($content, $attributesHelper = null)`: Create aside element
- `HtmlHelper::header($content, $attributesHelper = null)`: Create header element
- `HtmlHelper::footer($content, $attributesHelper = null)`: Create footer element
- `HtmlHelper::main($content, $attributesHelper = null)`: Create main element

##### Media Elements:
- `HtmlHelper::figure($content, $attributesHelper = null)`: Create figure element
- `HtmlHelper::figcaption($content, $attributesHelper = null)`: Create figure caption element

##### Interactive Elements:
- `HtmlHelper::details($content, $open = false, $attributesHelper = null)`: Create details element with optional open state
- `HtmlHelper::summary($content, $attributesHelper = null)`: Create summary element for details
- `HtmlHelper::dialog($content, $open = false, $modal = false, $attributesHelper = null)`: Create dialog element with optional open and modal states

##### Progress & Measurement Elements:
- `HtmlHelper::meter($content, $value, $min = null, $max = null, $low = null, $high = null, $optimum = null, $attributesHelper = null)`: Create meter element with value ranges
- `HtmlHelper::progress($content, $value = null, $max = null, $attributesHelper = null)`: Create progress element with optional value and max

### JSON Helper (`JsonHelper.php`)
JSON validation and manipulation utilities.

#### Key Functions:
- `JsonHelper::isValid($value)`: Validate various data types and JSON strings
- Support for complex JSON structures and nested objects

### Number Helper (`NumberHelper.php`)
Number formatting and manipulation utilities.

#### Key Functions:
- `NumberHelper::ordinal($number)`: Convert number to ordinal suffix (1st, 2nd, 3rd, etc.)

### Random Helper (`RandomHelper.php`)
Random value generation utilities.

#### Key Functions:
- `RandomHelper::trueFalse()`: Generate random boolean value
- `RandomHelper::uniqid($prefix = '')`: Generate unique identifier with optional prefix

### Value Helper (`ValueHelper.php`)
Value validation and type checking utilities.

#### Key Functions:
- `ValueHelper::emptyToNull(&$string)`: Convert empty value to null
- `ValueHelper::isEmpty($value)`: Check if value is empty (works with function returns)
- `ValueHelper::isInteger($value)`: Check if value is integer or string containing only digits
- `ValueHelper::isFloat($value)`: Check if value is float or string containing valid float format
- `ValueHelper::isDateTime($date, $format = null)`: Check if value is valid datetime
- `ValueHelper::isBool($value)`: Check if value is boolean type
- `ValueHelper::isTrue($value)`: Check if value is strictly TRUE
- `ValueHelper::isFalse($value)`: Check if value is strictly FALSE
- `ValueHelper::isTrueLike($value)`: Check if value evaluates to true in boolean context
- `ValueHelper::isFalseLike($value)`: Check if value evaluates to false in boolean context

### Counter Helper (`CounterHelper.php`)
Counter implementation for tracking and incrementing values.

#### Key Functions:
- `CounterHelper::f($initialValue = 0)`: Create counter instance
- `CounterHelper::plusOne()`: Increment counter
- `CounterHelper::minusOne()`: Decrement counter
- `CounterHelper::getCurrentValue()`: Get current value
- `CounterHelper::getInitialValue()`: Get initial value
- `CounterHelper::getDifference()`: Calculate difference from initial value

### CSV Helper (`CsvHelper.php`)
CSV file handling and manipulation utilities.

#### Key Functions:
- `CsvHelper::fileToArray($file, $hasTitleRow = false)`: Parse CSV file to array
- `CsvHelper::arrayToCsvString($array, $delimiter = ',', $enclosure = '"')`: Convert array to CSV string

### Email Helper (`EmailHelper.php`)
Email validation and formatting utilities.

#### Key Functions:
- `EmailHelper::clean($emails, $delimiters = [',', ';'])`: Clean and normalize email addresses
- `EmailHelper::isValid($email)`: Validate email address format

### IO Helper (`IOHelper.php`)
File system operations and temporary file handling.

#### Key Functions:
- `IOHelper::createTmpDir($dir = null, $prefix = null, $absolute = false)`: Create temporary directory
- `IOHelper::createTmpFile($dir = null, $prefix = null, $absolute = false)`: Create temporary file
- `IOHelper::rmdirRecursive($dir)`: Recursively remove directory

### Timer Helper (`TimerHelper.php`)
Time measurement and execution timing utilities.

#### Key Functions:
- `TimerHelper::start($alias)`: Start a new timer with specified alias
- `TimerHelper::getDifference($alias)`: Get elapsed time for a running timer
- `TimerHelper::stop($alias)`: Stop a timer and return elapsed time

### Color Helper (`Color/HexHelper.php`)
Color manipulation and conversion utilities.

#### Key Functions:
- `HexHelper::adjustBrightness($hex, $steps)`: Adjust brightness of a hex color code (-255 to 255)

### HTTP Helpers

#### Request Helper (`Http/RequestHelper.php`)
Request environment detection utilities.

#### Key Functions:
- `RequestHelper::isCli()`: Check if script is running in CLI mode
- `RequestHelper::isHttps()`: Check if request is using HTTPS

#### URL Helper (`Http/UrlHelper.php`)
URL manipulation and generation utilities.

#### Key Functions:
- `UrlHelper::protocolHostPort()`: Get protocol, host, and port string
- `UrlHelper::query($parameters = null, $mergeGetVariables = true)`: Build query string from parameters
- `UrlHelper::currentUrl($includeQuery = true, $urlEncode = false)`: Get current full URL
- `UrlHelper::currentUri($includeQueryParams = true, $encode = false)`: Get current URI

### HTML Helpers

#### Form Helper (`Html/FormHelper.php`)
HTML form element generation utilities.

#### Key Functions:
- `FormHelper::open($action = null, $method = 'GET', $attributesHelper = null)`: Create form opening tag
- `FormHelper::close()`: Create form closing tag
- `FormHelper::text($name, $value = null, $attributesHelper = null)`: Create text input
- `FormHelper::password($name, $value = null, $attributesHelper = null)`: Create password input
- `FormHelper::email($name, $value = null, $attributesHelper = null)`: Create email input
- `FormHelper::color($name, $value = null, $attributesHelper = null)`: Create color input
- `FormHelper::date($name, $value = null, $attributesHelper = null)`: Create date input
- `FormHelper::datetime($name, $value = null, $attributesHelper = null)`: Create datetime input
- `FormHelper::datetimeLocal($name, $value = null, $attributesHelper = null)`: Create datetime-local input
- `FormHelper::month($name, $value = null, $attributesHelper = null)`: Create month input
- `FormHelper::number($name, $value = null, $attributesHelper = null)`: Create number input
- `FormHelper::range($name, $value, $min, $max, $attributesHelper = null)`: Create range input
- `FormHelper::search($name, $value = null, $attributesHelper = null)`: Create search input
- `FormHelper::tel($name, $value = null, $attributesHelper = null)`: Create telephone input
- `FormHelper::time($name, $value = null, $attributesHelper = null)`: Create time input
- `FormHelper::url($name, $value = null, $attributesHelper = null)`: Create URL input
- `FormHelper::week($name, $value = null, $attributesHelper = null)`: Create week input
- `FormHelper::hidden($name, $value = null, $attributesHelper = null)`: Create hidden input
- `FormHelper::textarea($name, $value = null, $attributesHelper = null)`: Create textarea
- `FormHelper::button($name, $value = null, $attributesHelper = null)`: Create button
- `FormHelper::submit($name, $value = null, $attributesHelper = null)`: Create submit button
- `FormHelper::label($value, $forId = null, $formId = null, $attributesHelper = null)`: Create label
- `FormHelper::select($name, array $options, $checkedValue = null, $attributesHelper = null)`: Create select
- `FormHelper::selectMultiple($name, array $options, $checkedValue = null, $attributesHelper = null)`: Create multiple select
- `FormHelper::option($value, $text, $selected = false)`: Create option
- `FormHelper::optgroup($label, $htmlContent, $attributesHelper = null)`: Create option group
- `FormHelper::checkbox($name, $value = null, $checked = false, $attributesHelper = null)`: Create checkbox
- `FormHelper::radio($name, $value = null, $checked = false, $attributesHelper = null)`: Create radio button

#### Attributes Helper (`Html/AttributesHelper.php`)
A powerful utility class for managing HTML attributes with proper escaping and validation.

```php
// Create a new instance with initial attributes
$attrs = AttributesHelper::f(['class' => 'btn']);

// Add more classes and attributes
$attrs->addClass('btn-primary')
     ->addStyle('margin', '10px')
     ->addData('toggle', 'modal');

// Render as HTML attributes string
echo $attrs; // outputs: class="btn btn-primary" style="margin:10px" data-toggle="modal"
```

##### Key Features:
- Type-safe attribute handling
- HTML escaping for security
- CSS style parsing and validation
- Data attribute management
- Class name management

##### Main Methods:
- `AttributesHelper::f($input = null)`: Create new instance (recommended factory method)
- `setAttribute(string $name, mixed $value)`: Set any attribute with validation
- `setId(string $value)`: Set the ID attribute
- `addClass(string|array $classes)`: Add one or more CSS classes
- `addData(string $name, mixed $value)`: Add a data attribute
- `addStyle(string $property, string $value)`: Add a CSS style property
- `render()`: Convert to HTML attributes string
- `toArray()`: Get all attributes as an array

#### Bootstrap Helper (`Html/BootstrapHelper.php`)
Bootstrap-specific HTML generation utilities.

#### Key Functions:
- `BootstrapHelper::glyphIcon($name, $attributesHelper = null)`: Create Bootstrap glyphicon span element

```php
use AndreasGlaser\Helpers\Html\BootstrapHelper;

// Basic glyphicon
echo BootstrapHelper::glyphIcon('home');
// Output: <span class="glyphicon glyphicon-home"></span>

// With additional attributes
echo BootstrapHelper::glyphIcon('search', [
    'id' => 'search-icon',
    'class' => 'icon-large text-primary',
    'title' => 'Search',
    'data-toggle' => 'tooltip'
]);
// Output: <span id="search-icon" class="icon-large text-primary glyphicon glyphicon-search" title="Search" data-toggle="tooltip"></span>

// Using AttributesHelper
$attrs = AttributesHelper::f()
    ->setId('my-icon')
    ->addClass('text-danger')
    ->addData('action', 'delete');
echo BootstrapHelper::glyphIcon('trash', $attrs);
```

#### Table Helper (`Html/Table/TableHelper.php`)
HTML table generation utilities.

#### Key Functions:
- `TableHelper::f($headRows = null, $bodyRows = null, $attributesHelper = null)`: Create table instance
- `TableHelper::addHeadRow($rowHelper, $setCellAsHeaders = true)`: Add header row
- `TableHelper::addBodyRow($rowHelper)`: Add body row
- `TableHelper::render($renderer = null)`: Render table as HTML

#### List Helpers

##### Base List Helper (`Html/Lists/BaseListHelper.php`)
Base class for HTML list generation.

#### Key Functions:
- `BaseListHelper::f($items = null, $attributesHelper = null)`: Create list instance
- `BaseListHelper::addItem($content, $attributesHelper = null)`: Add item to list
- `BaseListHelper::getItems()`: Get all list items
- `BaseListHelper::getAttributes()`: Get list attributes

##### Unordered List Helper (`Html/Lists/UnorderedListHelper.php`)
HTML unordered list generation utilities.

#### Key Functions:
- `UnorderedListHelper::render($renderer = null)`: Render unordered list as HTML

##### Ordered List Helper (`Html/Lists/OrderedListHelper.php`)
HTML ordered list generation utilities.

#### Key Functions:
- `OrderedListHelper::render($renderer = null)`: Render ordered list as HTML

##### Description List Helper (`Html/Lists/DescriptionListHelper.php`)
HTML description list generation utilities.

#### Key Functions:
- `DescriptionListHelper::addTerm($term, $description, $attributesHelper = null)`: Add term and description
- `DescriptionListHelper::render($renderer = null)`: Render description list as HTML

### View Helper (`View/PHPView.php`)
PHP template rendering and view management utilities.

#### Key Functions:
- `PHPView::f($file = null, $data = [])`: Create view instance
- `PHPView::setGlobal($key, $value)`: Set global data accessible to all views
- `PHPView::getGlobalData()`: Get all global data
- `PHPView::setFile($filePath)`: Set template file path
- `PHPView::set($key, $value)`: Set local data for view instance
- `PHPView::getData()`: Get all local data
- `PHPView::render($file = null)`: Render template with current data
- `PHPView::__toString()`: Render template when used as string

### Network Helper (`Validate/NetworkHelper.php`)
Network-related validation utilities.

#### Key Functions:
- `NetworkHelper::isValidIPv4($ip)`: Validate IPv4 address format
- `NetworkHelper::isValidIPv6($ip)`: Validate IPv6 address format
- `NetworkHelper::isValidIP($ip, $allowPrivate = true, $allowReserved = true)`: Validate IP address (both IPv4 and IPv6) with support for private and reserved range validation
- `NetworkHelper::isValidPort($port, $allowSystemPorts = true, $allowUserPorts = true, $allowDynamicPorts = true)`: Validate port number with customizable range restrictions
- `NetworkHelper::isValidDomain($domain, $allowSingleLabel = false, $allowPunycode = true)`: Validate domain name with support for Punycode and single-label domains
- `NetworkHelper::isValidMac($mac, $allowColonFormat = true, $allowHyphenFormat = true, $allowBareFormat = true)`: Validate MAC address in various formats
- `NetworkHelper::isValidCidr($cidr)`: Validate CIDR notation for both IPv4 and IPv6
- `NetworkHelper::isValidSubnetMask($mask)`: Validate IPv4 subnet mask
- `NetworkHelper::getCommonPort($service)`: Get common port number for well-known services

##### DNS Operations:
- `NetworkHelper::getDnsRecords($domain, $type = 'ALL')`: Get DNS records for a domain with support for all record types (A, AAAA, MX, NS, TXT, etc.)
- `NetworkHelper::isValidMxRecord($domain)`: Check if a domain has valid MX records
- `NetworkHelper::getReverseDns($ip)`: Get reverse DNS (PTR) record for an IP address
- `NetworkHelper::hasValidSpfRecord($domain)`: Check if a domain has a valid SPF record
- `NetworkHelper::hasDkimRecord($domain, $selector)`: Check if a domain has a valid DKIM record for a selector

##### Socket and Port Operations:
- `NetworkHelper::isPortOpen($host, $port, $timeout = 2.0)`: Check if a specific port is open on a host
- `NetworkHelper::getOpenPorts($host, array $ports, $timeout = 1.0)`: Scan multiple ports on a host
- `NetworkHelper::getServiceByPort($port)`: Get service name for a port number (e.g., 80 → "http")

### Validation Helpers

#### Expect Helper (`Validate/Expect.php`)
Type validation utilities that throw exceptions on type mismatches. All methods throw `UnexpectedTypeException` if the value doesn't match the expected type.

##### Basic Type Validation:
- `Expect::int($value)`: Validates that a value is an integer
- `Expect::float($value)`: Validates that a value is a float
- `Expect::str($value)`: Validates that a value is a string
- `Expect::bool($value)`: Validates that a value is a boolean
- `Expect::arr($value)`: Validates that a value is an array
- `Expect::obj($value)`: Validates that a value is an object
- `Expect::res($value)`: Validates that a value is a resource
- `Expect::null($value)`: Validates that a value is null

##### Special Type Validation:
- `Expect::numeric($value)`: Validates that a value is numeric (int, float, or numeric string)
- `Expect::isCallable($value)`: Validates that a value is callable (function, closure, method array, etc.)
- `Expect::scalar($value)`: Validates that a value is scalar (int, float, string, or bool)

##### Built-in PHP Type Validation:
- `Expect::countable($value)`: Validates that a value is countable (array or implements Countable)
- `Expect::iterable($value)`: Validates that a value is iterable (array or implements Traversable)
- `Expect::finite($value)`: Validates that a value is a finite number (not infinite or NaN)
- `Expect::infinite($value)`: Validates that a value is an infinite number
- `Expect::nan($value)`: Validates that a value is NaN (Not a Number)

#### IOExpect Helper (`Validate/IOExpect.php`)
File system validation utilities that throw exceptions on validation failures. All methods throw `IOException` if the validation fails.

##### Path Existence and Type Validation:
- `IOExpect::exists($path)`: Validates that a path exists (file or directory)
- `IOExpect::doesNotExist($path)`: Validates that a path does not exist
- `IOExpect::isDir($path)`: Validates that a path exists and is a directory
- `IOExpect::isFile($path)`: Validates that a path exists and is a file
- `IOExpect::isLink($path)`: Validates that a path is a symbolic link

##### Permission Validation:
- `IOExpect::isReadable($path)`: Validates that a path is readable
- `IOExpect::isWritable($path)`: Validates that a path is writable
- `IOExpect::isExecutable($path)`: Validates that a path is executable
- `IOExpect::parentDirWritable($path)`: Validates that parent directory exists and is writable

##### Directory Content Validation:
- `IOExpect::isDirEmpty($path)`: Validates that a directory is empty
- `IOExpect::isDirNotEmpty($path)`: Validates that a directory is not empty

##### File Content and Properties Validation:
- `IOExpect::isFileNotEmpty($path)`: Validates that a file is not empty
- `IOExpect::hasMinSize($path, $minSize)`: Validates that a file has minimum size in bytes
- `IOExpect::hasMaxSize($path, $maxSize)`: Validates that a file has maximum size in bytes
- `IOExpect::hasExtension($path, $extension)`: Validates that a file has specific extension
- `IOExpect::hasAllowedExtension($path, $extensions)`: Validates that a file has one of allowed extensions
- `IOExpect::hasMimeType($path, $expectedMimeType)`: Validates that a file matches specific MIME type


## Testing

The library includes comprehensive unit tests for all components. Each helper class has a corresponding test class that verifies its functionality:

- `ArrayHelperTest`: Tests array manipulation and path operations
- `AttributesHelperTest`: Tests HTML attribute management and validation
- `BootstrapHelperTest`: Tests Bootstrap component generation and glyphicon creation
- `CounterHelperTest`: Tests counter operations and assertions
- `CsvHelperTest`: Tests CSV file operations and string conversion
- `DateHelperTest`: Tests date formatting and difference calculations
- `EmailHelperTest`: Tests email validation and cleaning
- `ExpectTest`: Tests type validation and exception throwing
- `FormHelperTest`: Tests HTML form element generation and validation
- `HtmlHelperTest`: Tests HTML element generation and attributes
- `IOExpectTest`: Tests file system validation and IOException handling
- `IOHelperTest`: Tests file system operations
- `JsonHelperTest`: Tests JSON validation for various data types
- `NumberHelperTest`: Tests number formatting and ordinal conversion
- `RandomHelperTest`: Tests random value generation
- `StringHelperTest`: Tests string comparison and manipulation methods
- `UrlHelperTest`: Tests URL generation, query string building, and server environment handling
- `ValueHelperTest`: Tests value validation and type checking

Run the tests using:

```bash
composer install
./vendor/phpunit/phpunit/phpunit
```

## Usage

```php
use AndreasGlaser\Helpers\ArrayHelper;
use AndreasGlaser\Helpers\StringHelper;
use AndreasGlaser\Helpers\DateHelper;
use AndreasGlaser\Helpers\ValueHelper;
use AndreasGlaser\Helpers\CsvHelper;
use AndreasGlaser\Helpers\EmailHelper;
use AndreasGlaser\Helpers\Html\FormHelper;
use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Validate\Expect;
use AndreasGlaser\Helpers\Validate\IOExpect;

// Array operations
$array = ['user' => ['profile' => ['name' => 'John']]];
$name = ArrayHelper::getByPath($array, 'user.profile.name'); // Returns 'John'

// String operations
$string = 'Hello World';
$contains = StringHelper::contains($string, 'World'); // Returns true
$startsWith = StringHelper::startsWith($string, 'Hello'); // Returns true

// Date operations
$date = new DateTime();
$hours = DateHelper::diffHours($date, new DateTime('+1 day')); // Returns 24

// Value validation
$isValid = ValueHelper::isDateTime('2024-03-20'); // Returns true

// CSV operations
$csvData = [
    ['Name', 'Email', 'Age'],
    ['John Doe', 'john@example.com', '30'],
    ['Jane Smith', 'jane@example.com', '25']
];
$csvString = CsvHelper::arrayToCsvString($csvData);
// Result: "Name,Email,Age\nJohn Doe,john@example.com,30\nJane Smith,jane@example.com,25"

// Read CSV file to array
$data = CsvHelper::fileToArray('users.csv', true); // true for header row
// With custom delimiter
$data = CsvHelper::fileToArray('data.csv', false, 0, ';'); // semicolon delimiter

// Email operations
$validEmail = EmailHelper::isValid('user@example.com'); // Returns true
$invalidEmail = EmailHelper::isValid('invalid-email'); // Returns false

// Clean and normalize email addresses
$emails = 'user@example.com, invalid-email, admin@test.com; contact@domain.org';
$cleanEmails = EmailHelper::clean($emails); // Returns ['user@example.com', 'admin@test.com', 'contact@domain.org']

// Clean with custom delimiters
$emails = 'user@example.com:admin@test.com#contact@domain.org';
$cleanEmails = EmailHelper::clean($emails, [':', '#']); // Returns ['user@example.com', 'admin@test.com', 'contact@domain.org']

// Clean array of emails
$emailArray = ['user@example.com', 'invalid', 'admin@test.com'];
$cleanEmails = EmailHelper::clean($emailArray); // Returns ['user@example.com', 'admin@test.com']

// Form generation
echo FormHelper::open('/users', 'POST', ['class' => 'user-form']);
echo FormHelper::text('name', 'John Doe', ['id' => 'name', 'required' => 'required']);
echo FormHelper::email('email', 'john@example.com', ['placeholder' => 'Enter email']);
echo FormHelper::select('country', ['US' => 'United States', 'CA' => 'Canada'], 'US');
echo FormHelper::textarea('bio', 'Tell us about yourself', ['rows' => 5]);
echo FormHelper::submit('submit', 'Create User', ['class' => 'btn btn-primary']);
echo FormHelper::close();

// HTML attribute management
$attrs = AttributesHelper::f(['class' => 'btn'])
    ->addClass('btn-primary')
    ->addStyle('margin', '10px')
    ->addData('toggle', 'modal');
echo $attrs; // outputs: class="btn btn-primary" style="margin:10px" data-toggle="modal"

// Type validation with exceptions
Expect::int(42);           // Valid - no exception
Expect::str('hello');      // Valid - no exception
Expect::finite(42.5);      // Valid - finite number

// File system validation
IOExpect::isFile('/path/to/file.txt');    // Throws IOException if not a file
IOExpect::isReadable('/path/to/file.txt'); // Throws IOException if not readable
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