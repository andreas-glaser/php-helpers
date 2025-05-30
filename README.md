# PHP Helpers

[![CI](https://github.com/andreas-glaser/php-helpers/workflows/CI/badge.svg)](https://github.com/andreas-glaser/php-helpers/actions)
[![PHP Version](https://img.shields.io/badge/php-8.2%2B-blue.svg)](https://www.php.net/)
[![Latest Stable Version](https://img.shields.io/packagist/v/andreas-glaser/php-helpers.svg)](https://packagist.org/packages/andreas-glaser/php-helpers)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/andreas-glaser/php-helpers.svg)](https://packagist.org/packages/andreas-glaser/php-helpers)

A comprehensive collection of PHP helper functions and classes to simplify common programming tasks.

## Requirements

- PHP ^8.2|^8.3
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

#### Usage Examples:
```php
use AndreasGlaser\Helpers\ArrayHelper;

// Basic array access with defaults
$config = ['database' => ['host' => 'localhost', 'port' => 3306]];
$host = ArrayHelper::get($config, 'database.host', 'default-host'); // "localhost"
$timeout = ArrayHelper::get($config, 'timeout', 30); // 30 (default value)

// Dot notation path operations
$user = ['profile' => ['personal' => ['name' => 'John', 'age' => 30]]];
$name = ArrayHelper::getByPath($user, 'profile.personal.name'); // "John"
$email = ArrayHelper::getByPath($user, 'profile.contact.email', false, 'no-email'); // "no-email"

// Setting values with dot notation
$data = [];
ArrayHelper::setByPath($data, 'user.settings.theme', 'dark');
// Result: ['user' => ['settings' => ['theme' => 'dark']]]

// Array manipulation
$fruits = ['apple', 'banana'];
$moreFruits = ArrayHelper::prepend($fruits, 'orange'); // ['orange', 'apple', 'banana']
$evenMore = ArrayHelper::append($moreFruits, 'grape'); // ['orange', 'apple', 'banana', 'grape']

// Array element operations
$numbers = [10, 20, 30, 40, 50];
$first = ArrayHelper::getFirstValue($numbers); // 10
$last = ArrayHelper::getLastValue($numbers); // 50
$random = ArrayHelper::getRandomValue($numbers); // Random number from array

// Key-value operations
$roles = ['admin' => 'Administrator', 'user' => 'Regular User', 'guest' => 'Guest'];
$adminKey = ArrayHelper::getKeyByValue($roles, 'Administrator'); // 'admin'

// String operations
$tags = ['php', '', 'programming', null, 'web'];
$cleanTags = ArrayHelper::unsetEmptyValues($tags); // ['php', 'programming', 'web']
$tagString = ArrayHelper::implodeIgnoreEmpty(', ', $tags); // "php, programming, web"

// Array structure operations
$mixed = ['firstName' => 'John', 'lastName' => 'Doe'];
$isAssoc = ArrayHelper::isAssoc($mixed); // true

$snakeCase = ArrayHelper::keysCamelToUnderscore(['firstName' => 'John', 'lastName' => 'Doe']);
// Result: ['first_name' => 'John', 'last_name' => 'Doe']

// Value transformations
$words = ['hello', 'world'];
$uppercase = ArrayHelper::valueToUpper($words); // ['HELLO', 'WORLD']

// String to array conversion
$csvData = "apple,,banana,  ,cherry";
$fruits = ArrayHelper::explodeIgnoreEmpty(',', $csvData); // ['apple', 'banana', 'cherry']

// Complex array merging
$array1 = [0 => 'a', 1 => 'b', 'key1' => 'value1'];
$array2 = [0 => 'c', 1 => 'd', 'key2' => 'value2'];
$merged = ArrayHelper::merge($array1, $array2);
// Properly handles numeric and string keys

// Advanced operations
$products = [
    ['name' => 'Laptop', 'price' => 1000],
    ['name' => 'Phone', 'price' => 500],
    ['name' => 'Tablet', 'price' => 300]
];

// Insert new product before 'Phone'
ArrayHelper::insertBefore($products, 1, [['name' => 'Desktop', 'price' => 800]]);

// Replace all occurrences of a value
$items = ['red', 'blue', 'red', 'green'];
$updated = ArrayHelper::replaceValue($items, 'red', 'crimson');
// Result: ['crimson', 'blue', 'crimson', 'green']
```

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

#### Usage Examples:
```php
use AndreasGlaser\Helpers\StringHelper;

// String comparison and validation
$password = "MySecretPassword";
$isValid = StringHelper::is($password, "MySecretPassword"); // true
$isCaseInsensitive = StringHelper::is($password, "mysecretpassword", false); // true

// Multiple string matching
$userRole = "admin";
$isAuthorized = StringHelper::isOneOf($userRole, ['admin', 'moderator', 'editor']); // true

// String content checking
$email = "user@example.com";
$hasAt = StringHelper::contains($email, "@"); // true
$isGmail = StringHelper::contains($email, "gmail", false); // false
$startsWithUser = StringHelper::startsWith($email, "user"); // true
$endsWithCom = StringHelper::endsWith($email, ".com"); // true

// String cleaning and formatting
$messy = "  ,,;;Hello World!!  ,,;;  ";
$cleaned = StringHelper::trimMulti($messy, [' ', ',', ';', '!']); // "Hello World"

$leftCleaned = StringHelper::lTrimMulti($messy, [' ', ',', ';']); // "Hello World!!  ,,;;  "
$rightCleaned = StringHelper::rTrimMulti($messy, [' ', ',', ';', '!']); // "  ,,;;Hello World"

// Case conversion
$camelCase = "firstName";
$snakeCase = StringHelper::camelToUnderscore($camelCase); // "first_name"

// Whitespace management
$multiLine = "Line 1\n\nLine 2\r\nLine 3";
$singleLine = StringHelper::removeLineBreaks($multiLine); // "Line 1 Line 2 Line 3"
$withDashes = StringHelper::removeLineBreaks($multiLine, " - "); // "Line 1 - Line 2 - Line 3"

$redundant = "Too    many     spaces";
$normalized = StringHelper::removeRedundantWhiteSpaces($redundant); // "Too many spaces"

$spaced = "Hello World";
$underscored = StringHelper::replaceWhiteSpacesWithUnderscores($spaced); // "Hello_World"

// Machine-readable formatting
$title = "My Article Title!";
$slug = StringHelper::machineReadable($title); // "my-article-title"

// String building
$base = "Hello";
$withAppend = StringHelper::append($base, " World"); // "Hello World"
$withPrepend = StringHelper::prepend($base, "Say "); // "Say Hello"

// Character removal
$phone = "123-456-7890";
$digitsOnly = StringHelper::removeChar($phone, "-"); // "1234567890"

$messy = "H@e#l$l%o W^o&r*l(d)";
$clean = StringHelper::removeChars($messy, ['@', '#', '$', '%', '^', '&', '*', '(', ')']);
// Result: "Hello World"

// Advanced string operations
$csv = "apple, banana , cherry , date";
$fruits = StringHelper::explodeAndTrim(',', $csv); // ['apple', 'banana', 'cherry', 'date']

// Multiple replacements
$template = "Hello {name}, welcome to {site}!";
$message = StringHelper::replace($template, [
    '{name}' => 'John',
    '{site}' => 'Our Website'
]); // "Hello John, welcome to Our Website!"

// Text limiting
$longText = "This is a very long article with many words that we want to truncate.";
$summary = StringHelper::limitWords($longText, 8); // "This is a very long article with many..."
$excerpt = StringHelper::limitChars($longText, 30, '...', true); // "This is a very long article..."

// Utility functions
$emptyString = "   ";
$isBlank = StringHelper::isBlank($emptyString); // true

$url = "https://example.com/page";
$withoutProtocol = StringHelper::removeFromStart($url, "https://"); // "example.com/page"

$filename = "document.pdf";
$withoutExtension = StringHelper::removeFromEnd($filename, ".pdf"); // "document"

// Multi-line text processing
$paragraph = "Line 1\nLine 2\nLine 3";
$lines = StringHelper::linesToArray($paragraph); // ['Line 1', 'Line 2', 'Line 3']

// ID generation
$id1 = StringHelper::getIncrementalId("item"); // "item_1"
$id2 = StringHelper::getIncrementalId("item"); // "item_2"
$id3 = StringHelper::getIncrementalId("user"); // "user_1"
```

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

#### Usage Examples:
```php
use AndreasGlaser\Helpers\DateHelper;

// Date validation
$validDate = DateHelper::isDateTime('2024-03-20'); // true
$validFormat = DateHelper::isDateTime('20/03/2024', 'd/m/Y'); // true
$invalidDate = DateHelper::isDateTime('invalid-date'); // false

// String to DateTime conversion
$dateTime1 = DateHelper::stringToDateTime('2024-03-20 15:30:00');
$dateTime2 = DateHelper::stringToDateTime('2024-03-20', new DateTimeZone('Europe/London'));
$nullResult = DateHelper::stringToDateTime('invalid', null, 'default-value'); // 'default-value'

// Safe formatting with null handling
$date = new DateTime('2024-03-20 15:30:00');
$formatted = DateHelper::formatOrNull($date, 'Y-m-d'); // "2024-03-20"
$customFormat = DateHelper::formatOrNull($date, 'd/m/Y H:i'); // "20/03/2024 15:30"
$nullFormat = DateHelper::formatOrNull(null, 'Y-m-d', 'No date'); // "No date"

// Date difference calculations
$start = new DateTime('2024-01-01 10:00:00');
$end = new DateTime('2024-01-02 14:30:00');

// Hour differences
$hourDiff = DateHelper::diffHours($start, $end); // 28.5 hours
$hourDiffReverse = DateHelper::diffHours($end, $start); // -28.5 hours

// Day differences
$dayDiff = DateHelper::diffDays($start, $end); // 1 day
$dayDiffExact = DateHelper::diffDays(
    new DateTime('2024-01-01'),
    new DateTime('2024-01-15')
); // 14 days

// Month differences
$monthStart = new DateTime('2024-01-15');
$monthEnd = new DateTime('2024-04-20');
$monthDiff = DateHelper::diffMonths($monthStart, $monthEnd); // 3 months

// Year differences
$yearStart = new DateTime('2020-06-15');
$yearEnd = new DateTime('2024-08-20');
$yearDiff = DateHelper::diffYears($yearStart, $yearEnd); // 4 years

// Practical examples
$userBirthday = DateHelper::stringToDateTime('1990-05-15');
$currentDate = new DateTime();

if (DateHelper::isDateTime('1990-05-15')) {
    $age = DateHelper::diffYears($userBirthday, $currentDate);
    echo "User is {$age} years old";
}

// Event duration calculation
$eventStart = DateHelper::stringToDateTime('2024-03-20 09:00:00');
$eventEnd = DateHelper::stringToDateTime('2024-03-20 17:30:00');
$duration = DateHelper::diffHours($eventStart, $eventEnd); // 8.5 hours

// Project timeline
$projectStart = new DateTime('2024-01-01');
$projectEnd = new DateTime('2024-06-30');
$projectDuration = DateHelper::diffDays($projectStart, $projectEnd); // 181 days
$projectMonths = DateHelper::diffMonths($projectStart, $projectEnd); // 5 months

// Format validation and conversion
$userInput = '2024/03/20';
if (DateHelper::isDateTime($userInput, 'Y/m/d')) {
    $converted = DateHelper::stringToDateTime($userInput);
    $standardFormat = DateHelper::formatOrNull($converted, 'Y-m-d'); // "2024-03-20"
}

// Handle timezone conversions
$utcDate = DateHelper::stringToDateTime('2024-03-20 12:00:00', new DateTimeZone('UTC'));
$localDate = DateHelper::stringToDateTime('2024-03-20 12:00:00', new DateTimeZone('America/New_York'));
$timeDiff = DateHelper::diffHours($utcDate, $localDate); // Time zone difference

// Null-safe operations
$maybeDate = DateHelper::stringToDateTime($userInput, null, null);
$safeFormat = DateHelper::formatOrNull($maybeDate, 'F j, Y', 'Invalid date');
// Returns formatted date or "Invalid date" if parsing failed
```

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

#### Usage Examples:
```php
use AndreasGlaser\Helpers\HtmlHelper;
use AndreasGlaser\Helpers\Html\AttributesHelper;

// Basic HTML elements
echo HtmlHelper::div('Hello World'); // <div>Hello World</div>
echo HtmlHelper::p('This is a paragraph.'); // <p>This is a paragraph.</p>
echo HtmlHelper::span('Inline text'); // <span>Inline text</span>

// Headings
echo HtmlHelper::h1('Main Title'); // <h1>Main Title</h1>
echo HtmlHelper::h2('Subtitle'); // <h2>Subtitle</h2>
echo HtmlHelper::h3('Section Title'); // <h3>Section Title</h3>

// Links and images
echo HtmlHelper::a('https://example.com', 'Visit Example'); 
// <a href="https://example.com">Visit Example</a>

echo HtmlHelper::image('logo.png');
// <img src="logo.png" />

// With attributes
$attrs = AttributesHelper::f(['class' => 'btn btn-primary', 'id' => 'main-button']);
echo HtmlHelper::a('https://example.com', 'Click Me', $attrs);
// <a href="https://example.com" class="btn btn-primary" id="main-button">Click Me</a>

// Text formatting elements
echo HtmlHelper::strong('Important text'); // <strong>Important text</strong>
echo HtmlHelper::em('Emphasized text'); // <em>Emphasized text</em>
echo HtmlHelper::code('$variable = "value";'); // <code>$variable = "value";</code>
echo HtmlHelper::mark('Highlighted text'); // <mark>Highlighted text</mark>
echo HtmlHelper::small('Fine print'); // <small>Fine print</small>

// Preformatted text
$codeBlock = "function hello() {\n    return 'Hello World';\n}";
echo HtmlHelper::pre($codeBlock);
// <pre>function hello() {
//     return 'Hello World';
// }</pre>

// Subscript and superscript
echo HtmlHelper::sub('2'); // <sub>2</sub> (for H₂O)
echo HtmlHelper::sup('2'); // <sup>2</sup> (for x²)

// Semantic elements
echo HtmlHelper::blockquote('To be or not to be, that is the question.');
// <blockquote>To be or not to be, that is the question.</blockquote>

echo HtmlHelper::cite('Shakespeare'); // <cite>Shakespeare</cite>

echo HtmlHelper::time('March 20, 2024', '2024-03-20');
// <time datetime="2024-03-20">March 20, 2024</time>

echo HtmlHelper::abbr('HTML', 'HyperText Markup Language');
// <abbr title="HyperText Markup Language">HTML</abbr>

// Structural elements
echo HtmlHelper::article('Article content here');
// <article>Article content here</article>

echo HtmlHelper::section('Section content');
// <section>Section content</section>

echo HtmlHelper::nav('Navigation content');
// <nav>Navigation content</nav>

echo HtmlHelper::aside('Sidebar content');
// <aside>Sidebar content</aside>

echo HtmlHelper::header('Header content');
// <header>Header content</header>

echo HtmlHelper::footer('Footer content');
// <footer>Footer content</footer>

echo HtmlHelper::main('Main content');
// <main>Main content</main>

// Media elements
$imageContent = HtmlHelper::image('photo.jpg') . HtmlHelper::figcaption('Photo caption');
echo HtmlHelper::figure($imageContent);
// <figure><img src="photo.jpg" /><figcaption>Photo caption</figcaption></figure>

// Interactive elements
$detailsContent = 'Hidden content that can be revealed';
echo HtmlHelper::details($detailsContent, false);
// <details>Hidden content that can be revealed</details>

$summaryContent = HtmlHelper::summary('Click to expand') . $detailsContent;
echo HtmlHelper::details($summaryContent, true);
// <details open>...</details>

$dialogContent = 'This is a modal dialog';
echo HtmlHelper::dialog($dialogContent, true, true);
// <dialog open modal>This is a modal dialog</dialog>

// Progress and measurement elements
echo HtmlHelper::progress('Loading...', 50, 100);
// <progress value="50" max="100">Loading...</progress>

echo HtmlHelper::meter('Disk usage', 8, 0, 10, 2, 9, 5);
// <meter value="8" min="0" max="10" low="2" high="9" optimum="5">Disk usage</meter>

// HTML entity handling
$userInput = '<script>alert("XSS")</script>';
echo HtmlHelper::chars($userInput);
// &lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;

$htmlContent = 'Price: €50 & "Free" shipping';
echo HtmlHelper::entities($htmlContent);
// Price: &euro;50 &amp; &quot;Free&quot; shipping

// Auto-paragraph conversion
$text = "First paragraph.\n\nSecond paragraph.\nWith line break.";
echo HtmlHelper::autoParagraph($text);
// <p>First paragraph.</p>
// <p>Second paragraph.<br />
// With line break.</p>

// Complex example: Building a card component
$cardAttrs = AttributesHelper::f(['class' => 'card']);
$headerAttrs = AttributesHelper::f(['class' => 'card-header']);
$bodyAttrs = AttributesHelper::f(['class' => 'card-body']);

$cardHeader = HtmlHelper::div('Card Title', $headerAttrs);
$cardBody = HtmlHelper::div(
    HtmlHelper::p('Card content goes here.') .
    HtmlHelper::a('#', 'Read More', AttributesHelper::f(['class' => 'btn btn-primary'])),
    $bodyAttrs
);

echo HtmlHelper::div($cardHeader . $cardBody, $cardAttrs);
// <div class="card">
//     <div class="card-header">Card Title</div>
//     <div class="card-body">
//         <p>Card content goes here.</p>
//         <a href="#" class="btn btn-primary">Read More</a>
//     </div>
// </div>
```

### JSON Helper (`JsonHelper.php`)
JSON validation and manipulation utilities.

#### Key Functions:
- `JsonHelper::isValid($value)`: Validate various data types and JSON strings
- Support for complex JSON structures and nested objects

#### Usage Examples:
```php
use AndreasGlaser\Helpers\JsonHelper;

// Basic JSON validation
$validJson = '{"name": "John", "age": 30}';
$isValid = JsonHelper::isValid($validJson); // true

$invalidJson = '{"name": "John", "age":}';
$isInvalid = JsonHelper::isValid($invalidJson); // false

// Array validation
$array = ['name' => 'John', 'age' => 30];
$arrayValid = JsonHelper::isValid($array); // true

// Complex nested structures
$complexData = [
    'users' => [
        ['id' => 1, 'name' => 'John', 'active' => true],
        ['id' => 2, 'name' => 'Jane', 'active' => false]
    ],
    'meta' => ['total' => 2, 'page' => 1]
];
$complexValid = JsonHelper::isValid($complexData); // true

// Object validation
$stdClass = new stdClass();
$stdClass->name = 'Test';
$objectValid = JsonHelper::isValid($stdClass); // true

// Practical usage in API validation
function validateApiRequest($input) {
    if (!JsonHelper::isValid($input)) {
        throw new InvalidArgumentException('Invalid JSON data');
    }
    return json_decode($input, true);
}
```

### Number Helper (`NumberHelper.php`)
Comprehensive number formatting, conversion, validation, and mathematical operation utilities.

The NumberHelper provides extensive functionality for working with numbers including formatting, mathematical calculations, base conversions, Roman numerals, statistical operations, and validation methods.

#### Key Functions:

##### Basic Formatting:
- `NumberHelper::ordinal($number)`: Convert number to ordinal suffix (1st, 2nd, 3rd, etc.)
- `NumberHelper::format($number, $decimals = 2, $decimalSeparator = '.', $thousandsSeparator = ',')`: Format number with thousands separators and decimal places
- `NumberHelper::parse($formattedNumber, $decimalSeparator = '.', $thousandsSeparator = ',')`: Parse formatted number string back to numeric value

##### Percentage Operations:
- `NumberHelper::percentage($number, $isDecimal = true, $decimals = 2)`: Convert number to percentage string with % symbol
- `NumberHelper::percentageOf($value, $total, $decimals = 4)`: Calculate percentage of a value from total

##### Mathematical Operations:
- `NumberHelper::round($number, $precision = 0, $mode = PHP_ROUND_HALF_UP)`: Round number with specified precision and mode
- `NumberHelper::clamp($number, $min, $max)`: Clamp number between minimum and maximum values
- `NumberHelper::difference($a, $b)`: Calculate absolute difference between two numbers

##### File Size Formatting:
- `NumberHelper::fileSize($bytes, $decimals = 2, $binary = true)`: Convert bytes to human readable format (KB, MB, GB, etc.)
  - Supports both binary (1024) and decimal (1000) units

##### Roman Numeral Conversion:
- `NumberHelper::toRoman($number)`: Convert number (1-3999) to Roman numerals
- `NumberHelper::fromRoman($roman)`: Convert Roman numerals back to numbers

##### Number Base Conversion:
- `NumberHelper::changeBase($number, $fromBase, $toBase)`: Convert numbers between different bases (2-36)

##### Number Validation:
- `NumberHelper::inRange($number, $min, $max)`: Check if number is within specified range (inclusive)
- `NumberHelper::isEven($number)`: Check if number is even
- `NumberHelper::isOdd($number)`: Check if number is odd
- `NumberHelper::isPrime($number)`: Check if number is prime

##### Statistical Operations:
- `NumberHelper::average($numbers)`: Calculate average of an array of numbers
- `NumberHelper::median($numbers)`: Find median value in an array of numbers

#### Usage Examples:
```php
use AndreasGlaser\Helpers\NumberHelper;

// Basic formatting
echo NumberHelper::format(1234567.89); // "1,234,567.89"
echo NumberHelper::format(1234567.89, 1, ',', ' '); // "1 234 567,9"

// Ordinal numbers
echo NumberHelper::ordinal(1) . NumberHelper::ordinal(22); // "st" . "nd" = "stnd"

// Percentages
echo NumberHelper::percentage(0.75); // "75.00%"
echo NumberHelper::percentageOf(75, 300); // 0.25 (25%)

// File sizes
echo NumberHelper::fileSize(1536); // "1.50 KB"
echo NumberHelper::fileSize(1000000, 2, false); // "1.00 MB" (decimal)

// Roman numerals
echo NumberHelper::toRoman(1984); // "MCMLXXXIV"
echo NumberHelper::fromRoman("MCMLXXXIV"); // 1984

// Number base conversion
echo NumberHelper::changeBase(255, 10, 16); // "ff"
echo NumberHelper::changeBase("ff", 16, 10); // "255"

// Mathematical operations
echo NumberHelper::clamp(150, 0, 100); // 100
echo NumberHelper::round(1.235, 2); // 1.24

// Validation
var_dump(NumberHelper::isPrime(17)); // true
var_dump(NumberHelper::isEven(42)); // true
var_dump(NumberHelper::inRange(15, 10, 20)); // true

// Statistics
echo NumberHelper::average([1, 2, 3, 4, 5]); // 3.0
echo NumberHelper::median([1, 2, 3, 4, 5]); // 3.0

// Parsing
echo NumberHelper::parse("1,234.56"); // 1234.56
echo NumberHelper::parse("1 234,56", ",", " "); // 1234.56
```

### Random Helper (`RandomHelper.php`)
Comprehensive random value generation utilities for secure and flexible random data creation.

The RandomHelper provides extensive functionality for generating various types of random values including basic primitives, secure cryptographic strings, network addresses, colors, and specialized data types with comprehensive customization options.

#### Key Functions:

##### Basic Random Generation:
- `RandomHelper::trueFalse()`: Generate random boolean value with 50% probability
- `RandomHelper::int($min = 0, $max = PHP_INT_MAX)`: Generate random integer within range
- `RandomHelper::float($min = 0.0, $max = 1.0, $precision = 2)`: Generate random float with specified precision

##### String Generation:
- `RandomHelper::string($length, $charset = CHARSET_ALPHANUMERIC)`: Generate random string with customizable character set
- `RandomHelper::secureString($length, $charset = CHARSET_ALPHANUMERIC)`: Generate cryptographically secure random string
- `RandomHelper::uniqid($prefix = '')`: Generate cryptographically secure unique identifier

##### Password and Token Generation:
- `RandomHelper::password($length = 12, $includeUppercase = true, $includeLowercase = true, $includeNumbers = true, $includeSpecial = true, $excludeChars = '')`: Generate secure passwords with customizable criteria
- `RandomHelper::token($length = 32, $urlSafe = true)`: Generate secure tokens for API keys or sessions
- `RandomHelper::uuid4()`: Generate Version 4 UUID (random)

##### Array Operations:
- `RandomHelper::arrayElement($array)`: Select random element from array
- `RandomHelper::arrayElements($array, $count)`: Select multiple random elements without replacement
- `RandomHelper::shuffle($array)`: Shuffle array without modifying original
- `RandomHelper::weighted($weights)`: Weighted random selection based on probability distribution

##### Color Generation:
- `RandomHelper::hexColor($includeHash = true)`: Generate random hexadecimal color code
- `RandomHelper::rgbColor()`: Generate random RGB color array with r, g, b values (0-255)

##### Network Address Generation:
- `RandomHelper::ipAddress($version = 4, $private = false)`: Generate random IP addresses (IPv4/IPv6, public/private ranges)
- `RandomHelper::macAddress($separator = ':', $uppercase = false)`: Generate random MAC addresses with customizable format

##### Date and Time:
- `RandomHelper::date($start, $end, $format = 'Y-m-d')`: Generate random date between two dates in specified format

##### Character Set Constants:
- `CHARSET_NUMERIC`: '0123456789'
- `CHARSET_ALPHA_LOWER`: 'abcdefghijklmnopqrstuvwxyz'
- `CHARSET_ALPHA_UPPER`: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
- `CHARSET_ALPHA`: Lower and uppercase letters combined
- `CHARSET_ALPHANUMERIC`: Letters and numbers combined
- `CHARSET_SPECIAL`: Special characters for passwords
- `CHARSET_PASSWORD`: All password-safe characters
- `CHARSET_HEX`: Hexadecimal characters
- `CHARSET_BASE64`: Base64 encoding characters

#### Usage Examples:
```php
use AndreasGlaser\Helpers\RandomHelper;

// Basic random generation
$randomBool = RandomHelper::trueFalse(); // true or false
$randomInt = RandomHelper::int(1, 100); // Integer between 1-100
$randomFloat = RandomHelper::float(0.0, 10.0, 2); // Float like 7.34

// String generation
$alphanumeric = RandomHelper::string(8); // "aB3kL9pQ"
$hexString = RandomHelper::string(6, RandomHelper::CHARSET_HEX); // "a3f2d1"
$secureString = RandomHelper::secureString(16); // Cryptographically secure

// Password generation
$password = RandomHelper::password(); // 12-char secure password
$customPassword = RandomHelper::password(16, true, true, true, false); // No special chars
$excludeAmbiguous = RandomHelper::password(10, true, true, true, false, '0O1Il'); // Exclude confusing chars

// Unique identifiers
$uniqueId = RandomHelper::uniqid(); // "a3f2d18bc4e7f"
$prefixedId = RandomHelper::uniqid('user_'); // "user_a3f2d18bc4e7f"
$uuid = RandomHelper::uuid4(); // "f47ac10b-58cc-4372-a567-0e02b2c3d479"
$token = RandomHelper::token(32); // URL-safe 32-character token

// Array operations
$fruits = ['apple', 'banana', 'cherry', 'date'];
$randomFruit = RandomHelper::arrayElement($fruits); // "banana"
$twoFruits = RandomHelper::arrayElements($fruits, 2); // ["cherry", "apple"]
$shuffled = RandomHelper::shuffle($fruits); // Randomly ordered array

// Weighted selection
$lootTable = ['common' => 70, 'rare' => 20, 'epic' => 10];
$loot = RandomHelper::weighted($lootTable); // More likely to be "common"

// Colors
$hexColor = RandomHelper::hexColor(); // "#a3f2d1"
$hexNoHash = RandomHelper::hexColor(false); // "a3f2d1"
$rgbColor = RandomHelper::rgbColor(); // ['r' => 163, 'g' => 242, 'b' => 209]

// Network addresses
$ipv4 = RandomHelper::ipAddress(); // "192.168.1.45"
$privateIp = RandomHelper::ipAddress(4, true); // "10.0.15.234"
$ipv6 = RandomHelper::ipAddress(6); // "2001:db8a:3c4d:5e6f:7890:1a2b:3c4d:5e6f"
$macAddress = RandomHelper::macAddress(); // "a3:f2:d1:8b:4c:7e"
$macDashes = RandomHelper::macAddress('-', true); // "A3-F2-D1-8B-4C-7E"

// Random dates
$start = new DateTime('2020-01-01');
$end = new DateTime('2023-12-31');
$randomDate = RandomHelper::date($start, $end); // "2022-07-15"
$customFormat = RandomHelper::date($start, $end, 'd/m/Y'); // "15/07/2022"
```

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

#### Usage Examples:
```php
use AndreasGlaser\Helpers\ValueHelper;

// Empty to null conversion
$input1 = "";
ValueHelper::emptyToNull($input1); // $input1 is now null

$input2 = "0";
ValueHelper::emptyToNull($input2); // $input2 is now null

$input3 = "hello";
ValueHelper::emptyToNull($input3); // $input3 remains "hello"

// Empty value checking
$isEmpty1 = ValueHelper::isEmpty(''); // true
$isEmpty2 = ValueHelper::isEmpty('0'); // true
$isEmpty3 = ValueHelper::isEmpty(0); // true
$isEmpty4 = ValueHelper::isEmpty(null); // true
$isEmpty5 = ValueHelper::isEmpty(false); // true
$isEmpty6 = ValueHelper::isEmpty([]); // true

$isNotEmpty1 = ValueHelper::isEmpty(' '); // false (space is not empty)
$isNotEmpty2 = ValueHelper::isEmpty('hello'); // false
$isNotEmpty3 = ValueHelper::isEmpty(1); // false
$isNotEmpty4 = ValueHelper::isEmpty([0]); // false

// Integer validation
$isInt1 = ValueHelper::isInteger(123); // true
$isInt2 = ValueHelper::isInteger('123'); // true (string containing only digits)
$isInt3 = ValueHelper::isInteger('123.0'); // false (contains decimal point)
$isInt4 = ValueHelper::isInteger(123.45); // false (is float)
$isInt5 = ValueHelper::isInteger('abc'); // false

// Float validation
$isFloat1 = ValueHelper::isFloat(123.45); // true
$isFloat2 = ValueHelper::isFloat('123.45'); // true (string containing valid float)
$isFloat3 = ValueHelper::isFloat(123); // false (is integer)
$isFloat4 = ValueHelper::isFloat('123'); // false (string integer)
$isFloat5 = ValueHelper::isFloat('abc'); // false

// DateTime validation
$isDateTime1 = ValueHelper::isDateTime('2024-03-20'); // true
$isDateTime2 = ValueHelper::isDateTime('2024-03-20 15:30:00'); // true
$isDateTime3 = ValueHelper::isDateTime('March 20, 2024'); // true
$isDateTime4 = ValueHelper::isDateTime('tomorrow'); // true
$isDateTime5 = ValueHelper::isDateTime('invalid-date'); // false
$isDateTime6 = ValueHelper::isDateTime('2024-13-50'); // false (invalid date)

// Boolean type checking
$isBool1 = ValueHelper::isBool(true); // true
$isBool2 = ValueHelper::isBool(false); // true
$isBool3 = ValueHelper::isBool(1); // false (integer, not boolean)
$isBool4 = ValueHelper::isBool('true'); // false (string, not boolean)

// Strict boolean value checking
$isTrue1 = ValueHelper::isTrue(true); // true
$isTrue2 = ValueHelper::isTrue(1); // false (not strictly true)
$isTrue3 = ValueHelper::isTrue('true'); // false (not strictly true)

$isFalse1 = ValueHelper::isFalse(false); // true
$isFalse2 = ValueHelper::isFalse(0); // false (not strictly false)
$isFalse3 = ValueHelper::isFalse(''); // false (not strictly false)

// Truthy/falsy evaluation
$isTrueLike1 = ValueHelper::isTrueLike(1); // true
$isTrueLike2 = ValueHelper::isTrueLike('hello'); // true
$isTrueLike3 = ValueHelper::isTrueLike([1, 2, 3]); // true
$isTrueLike4 = ValueHelper::isTrueLike(0); // false
$isTrueLike5 = ValueHelper::isTrueLike(''); // false

$isFalseLike1 = ValueHelper::isFalseLike(0); // true
$isFalseLike2 = ValueHelper::isFalseLike(''); // true
$isFalseLike3 = ValueHelper::isFalseLike(null); // true
$isFalseLike4 = ValueHelper::isFalseLike([]); // true
$isFalseLike5 = ValueHelper::isFalseLike(1); // false
$isFalseLike6 = ValueHelper::isFalseLike('hello'); // false

// Practical examples
function sanitizeFormInput($input) {
    // Convert empty strings to null
    ValueHelper::emptyToNull($input);
    
    if (ValueHelper::isEmpty($input)) {
        return null;
    }
    
    return trim($input);
}

function validateUserAge($age) {
    if (!ValueHelper::isInteger($age)) {
        throw new InvalidArgumentException('Age must be an integer');
    }
    
    $ageInt = (int)$age;
    if ($ageInt < 0 || $ageInt > 150) {
        throw new InvalidArgumentException('Age must be between 0 and 150');
    }
    
    return $ageInt;
}

function validatePrice($price) {
    if (!ValueHelper::isFloat($price) && !ValueHelper::isInteger($price)) {
        throw new InvalidArgumentException('Price must be a number');
    }
    
    $priceFloat = (float)$price;
    if ($priceFloat < 0) {
        throw new InvalidArgumentException('Price cannot be negative');
    }
    
    return $priceFloat;
}

function validateBirthDate($date) {
    if (!ValueHelper::isDateTime($date)) {
        throw new InvalidArgumentException('Invalid birth date format');
    }
    
    $birthDate = new DateTime($date);
    $now = new DateTime();
    
    if ($birthDate > $now) {
        throw new InvalidArgumentException('Birth date cannot be in the future');
    }
    
    return $birthDate;
}

// Configuration validation
function validateConfigValue($key, $value) {
    $config = [
        'debug' => 'boolean',
        'timeout' => 'integer',
        'rate' => 'float',
        'start_date' => 'datetime'
    ];
    
    if (!isset($config[$key])) {
        throw new InvalidArgumentException("Unknown config key: $key");
    }
    
    switch ($config[$key]) {
        case 'boolean':
            if (!ValueHelper::isBool($value)) {
                throw new InvalidArgumentException("$key must be a boolean");
            }
            break;
        case 'integer':
            if (!ValueHelper::isInteger($value)) {
                throw new InvalidArgumentException("$key must be an integer");
            }
            break;
        case 'float':
            if (!ValueHelper::isFloat($value)) {
                throw new InvalidArgumentException("$key must be a float");
            }
            break;
        case 'datetime':
            if (!ValueHelper::isDateTime($value)) {
                throw new InvalidArgumentException("$key must be a valid datetime");
            }
            break;
    }
    
    return $value;
}
```

### Counter Helper (`CounterHelper.php`)
Counter implementation for tracking and incrementing values with comprehensive functionality.

The CounterHelper provides a flexible counter that can be initialized with integer values or arrays (counts elements). It supports fluent method chaining for multiple operations and tracks both initial and current values for difference calculations.

#### Key Functions:

##### Factory and Instantiation:
- `CounterHelper::f($initialValue = 0)`: Factory method to create counter instance
  - Accepts integers or arrays (counts array elements as initial value)
  - Returns new CounterHelper instance

##### Value Operations:
- `CounterHelper::increaseBy($value)`: Increase counter by specified amount (supports method chaining)
- `CounterHelper::decreaseBy($value)`: Decrease counter by specified amount (supports method chaining)
- `CounterHelper::plusOne()`: Increment counter by 1 (supports method chaining)
- `CounterHelper::minusOne()`: Decrement counter by 1 (supports method chaining)

##### Value Tracking:
- `CounterHelper::getCurrentValue()`: Get current counter value
- `CounterHelper::getInitialValue()`: Get initial counter value
- `CounterHelper::getDifference()`: Calculate absolute difference between current and initial values

##### Utility:
- `CounterHelper::__toString()`: Convert counter to string representation of current value

#### Usage Examples:
```php
// Basic usage
$counter = CounterHelper::f(10);
$counter->plusOne()->increaseBy(5)->minusOne(); // Result: 15

// Array initialization  
$items = ['a', 'b', 'c'];
$inventory = CounterHelper::f($items); // Starts with count of 3

// Difference tracking
$counter = CounterHelper::f(100);
$counter->decreaseBy(25);
echo $counter->getDifference(); // Outputs: 25
```

### CSV Helper (`CsvHelper.php`)
CSV file handling and manipulation utilities.

#### Key Functions:
- `CsvHelper::fileToArray($file, $hasTitleRow = false)`: Parse CSV file to array
- `CsvHelper::arrayToCsvString($array, $delimiter = ',', $enclosure = '"')`: Convert array to CSV string

#### Usage Examples:
```php
use AndreasGlaser\Helpers\CsvHelper;

// Convert array to CSV string
$userData = [
    ['Name', 'Email', 'Age'],
    ['John Doe', 'john@example.com', '30'],
    ['Jane Smith', 'jane@example.com', '25'],
    ['Bob Johnson', 'bob@example.com', '35']
];

$csvString = CsvHelper::arrayToCsvString($userData);
// Result: "Name,Email,Age\nJohn Doe,john@example.com,30\n..."

// Custom delimiter
$csvWithSemicolon = CsvHelper::arrayToCsvString($userData, ';');
// Result: "Name;Email;Age\nJohn Doe;john@example.com;30\n..."

// Read CSV file to array (with header row)
$data = CsvHelper::fileToArray('users.csv', true);
// Returns associative array with header keys

// Read CSV file without header
$rawData = CsvHelper::fileToArray('data.csv', false);
// Returns indexed array

// Practical example: Export users to CSV
$users = [
    ['id' => 1, 'name' => 'John', 'email' => 'john@example.com'],
    ['id' => 2, 'name' => 'Jane', 'email' => 'jane@example.com']
];

// Convert to CSV format
$csvData = [['ID', 'Name', 'Email']];
foreach ($users as $user) {
    $csvData[] = [$user['id'], $user['name'], $user['email']];
}

$csvOutput = CsvHelper::arrayToCsvString($csvData);
file_put_contents('users_export.csv', $csvOutput);
```

### Email Helper (`EmailHelper.php`)
Email validation and formatting utilities.

#### Key Functions:
- `EmailHelper::clean($emails, $delimiters = [',', ';'])`: Clean and normalize email addresses
- `EmailHelper::isValid($email)`: Validate email address format

#### Usage Examples:
```php
use AndreasGlaser\Helpers\EmailHelper;

// Email validation
$validEmail = EmailHelper::isValid('user@example.com'); // true
$invalidEmail = EmailHelper::isValid('invalid-email'); // false
$anotherValid = EmailHelper::isValid('test.email+tag@domain.co.uk'); // true

// Clean email list from string
$emailString = 'user@example.com, invalid-email, admin@test.com; contact@domain.org';
$cleanEmails = EmailHelper::clean($emailString);
// Result: ['user@example.com', 'admin@test.com', 'contact@domain.org']

// Custom delimiters
$customDelimited = 'user@example.com:admin@test.com#contact@domain.org';
$cleanCustom = EmailHelper::clean($customDelimited, [':', '#']);
// Result: ['user@example.com', 'admin@test.com', 'contact@domain.org']

// Clean array of emails
$emailArray = ['user@example.com', 'invalid', 'admin@test.com', '', 'test@domain.com'];
$cleanedArray = EmailHelper::clean($emailArray);
// Result: ['user@example.com', 'admin@test.com', 'test@domain.com']

// Practical example: Newsletter signup validation
function processNewsletterSignup($emailInput) {
    $emails = EmailHelper::clean($emailInput);
    $validEmails = [];
    
    foreach ($emails as $email) {
        if (EmailHelper::isValid($email)) {
            $validEmails[] = $email;
        }
    }
    
    return $validEmails;
}

$signupInput = 'john@example.com, jane@invalid, bob@test.com';
$validSubscribers = processNewsletterSignup($signupInput);
// Result: ['john@example.com', 'bob@test.com']
```

### IO Helper (`IOHelper.php`)
File system operations and temporary file handling.

#### Key Functions:
- `IOHelper::createTmpDir($dir = null, $prefix = null, $absolute = false)`: Create temporary directory
- `IOHelper::createTmpFile($dir = null, $prefix = null, $absolute = false)`: Create temporary file
- `IOHelper::rmdirRecursive($dir)`: Recursively remove directory

#### Usage Examples:
```php
use AndreasGlaser\Helpers\IOHelper;

// Create temporary directory
$tmpDir = IOHelper::createTmpDir(); // Creates temp dir in system temp
$customTmpDir = IOHelper::createTmpDir('/custom/path', 'myapp_'); // Custom location with prefix
$absoluteTmpDir = IOHelper::createTmpDir(null, 'app_', true); // Absolute path returned

// Create temporary file
$tmpFile = IOHelper::createTmpFile(); // Creates temp file in system temp
$customTmpFile = IOHelper::createTmpFile('/tmp', 'data_'); // Custom location with prefix
$absoluteTmpFile = IOHelper::createTmpFile(null, 'log_', true); // Absolute path returned

// Recursive directory removal
$testDir = '/path/to/directory/with/subdirs';
IOHelper::rmdirRecursive($testDir); // Removes directory and all contents

// Practical example: File processing workflow
function processUploadedFiles($files) {
    // Create temporary working directory
    $workDir = IOHelper::createTmpDir(null, 'upload_processing_');
    
    try {
        foreach ($files as $file) {
            // Create temporary file for processing
            $tmpFile = IOHelper::createTmpFile($workDir, 'process_');
            
            // Process file (resize, convert, etc.)
            // ... processing logic here ...
            
            // Clean up individual temp file when done
            unlink($tmpFile);
        }
    } finally {
        // Clean up entire working directory
        IOHelper::rmdirRecursive($workDir);
    }
}

// Batch file processing
$processingDir = IOHelper::createTmpDir(null, 'batch_');
$logFile = IOHelper::createTmpFile($processingDir, 'processing_log_');

// Write processing logs
file_put_contents($logFile, "Processing started at " . date('Y-m-d H:i:s') . "\n");

// ... do processing work ...

// Cleanup when done
IOHelper::rmdirRecursive($processingDir);
```

### Timer Helper (`TimerHelper.php`)
Time measurement and execution timing utilities.

#### Key Functions:
- `TimerHelper::start($alias)`: Start a new timer with specified alias
- `TimerHelper::getDifference($alias)`: Get elapsed time for a running timer
- `TimerHelper::stop($alias)`: Stop a timer and return elapsed time

#### Usage Examples:
```php
use AndreasGlaser\Helpers\TimerHelper;

// Basic timing
TimerHelper::start('page_load');
// ... do some work ...
$pageLoadTime = TimerHelper::stop('page_load'); // Returns elapsed time in seconds

// Multiple timers
TimerHelper::start('database_query');
TimerHelper::start('api_call');

// Check elapsed time without stopping
sleep(1);
$dbElapsed = TimerHelper::getDifference('database_query'); // ~1.0 seconds

// Complete the operations
sleep(2);
$apiTime = TimerHelper::stop('api_call'); // ~3.0 seconds
$dbTime = TimerHelper::stop('database_query'); // ~3.0 seconds

// Performance monitoring example
function monitoredFunction() {
    TimerHelper::start('function_execution');
    
    // Simulate some work
    TimerHelper::start('database_operations');
    // ... database work ...
    $dbTime = TimerHelper::stop('database_operations');
    
    TimerHelper::start('api_requests');
    // ... API calls ...
    $apiTime = TimerHelper::stop('api_requests');
    
    $totalTime = TimerHelper::stop('function_execution');
    
    return [
        'total_time' => $totalTime,
        'database_time' => $dbTime,
        'api_time' => $apiTime,
        'other_time' => $totalTime - $dbTime - $apiTime
    ];
}

// Benchmark comparison
function benchmarkSortingAlgorithms($data) {
    $results = [];
    
    // Test bubble sort
    $testData1 = $data;
    TimerHelper::start('bubble_sort');
    bubbleSort($testData1);
    $results['bubble_sort'] = TimerHelper::stop('bubble_sort');
    
    // Test quick sort
    $testData2 = $data;
    TimerHelper::start('quick_sort');
    quickSort($testData2);
    $results['quick_sort'] = TimerHelper::stop('quick_sort');
    
    return $results;
}

// Request processing timing
TimerHelper::start('request_processing');

TimerHelper::start('authentication');
// ... authenticate user ...
$authTime = TimerHelper::stop('authentication');

TimerHelper::start('business_logic');
// ... main application logic ...
$businessTime = TimerHelper::stop('business_logic');

TimerHelper::start('response_generation');
// ... generate response ...
$responseTime = TimerHelper::stop('response_generation');

$totalRequestTime = TimerHelper::stop('request_processing');

// Log performance metrics
error_log("Request timing - Auth: {$authTime}s, Business: {$businessTime}s, Response: {$responseTime}s, Total: {$totalRequestTime}s");
```

### Color Helper (`Color/HexHelper.php`)
Color manipulation and conversion utilities.

#### Key Functions:
- `HexHelper::adjustBrightness($hex, $steps)`: Adjust brightness of a hex color code (-255 to 255)

#### Usage Examples:
```php
use AndreasGlaser\Helpers\Color\HexHelper;

// Brighten colors
$originalColor = '#3498db';
$lighterColor = HexHelper::adjustBrightness($originalColor, 50); // Lighter blue
$darkerColor = HexHelper::adjustBrightness($originalColor, -50); // Darker blue

// Maximum brightness adjustments
$white = HexHelper::adjustBrightness('#000000', 255); // Black to white
$black = HexHelper::adjustBrightness('#ffffff', -255); // White to black

// Theme color generation
$primaryColor = '#2c3e50';
$colors = [
    'primary' => $primaryColor,
    'primary_light' => HexHelper::adjustBrightness($primaryColor, 30),
    'primary_lighter' => HexHelper::adjustBrightness($primaryColor, 60),
    'primary_dark' => HexHelper::adjustBrightness($primaryColor, -30),
    'primary_darker' => HexHelper::adjustBrightness($primaryColor, -60),
];

// Dynamic hover effects
function generateHoverColor($baseColor) {
    return HexHelper::adjustBrightness($baseColor, 20);
}

$buttonColor = '#e74c3c';
$buttonHover = generateHoverColor($buttonColor); // Lighter red for hover state

// Color palette generation
function generateColorPalette($baseColor, $steps = 5) {
    $palette = [];
    $stepSize = 255 / $steps;
    
    for ($i = -$steps; $i <= $steps; $i++) {
        $adjustment = $i * $stepSize;
        $palette[] = HexHelper::adjustBrightness($baseColor, $adjustment);
    }
    
    return $palette;
}

$brandColor = '#9b59b6';
$purplePalette = generateColorPalette($brandColor, 3);
// Returns array of purple shades from dark to light
```

### HTTP Helpers

#### Request Helper (`Http/RequestHelper.php`)
Request environment detection and comprehensive HTTP request analysis utilities.

#### Key Functions:

##### Environment Detection:
- `RequestHelper::isCli()`: Check if script is running in CLI mode
- `RequestHelper::isHttps()`: Check if request is using HTTPS (enhanced with proxy detection)
- `RequestHelper::isSecure()`: Check if request is secure (HTTPS or localhost)
- `RequestHelper::isLocalhost()`: Check if request is from localhost

##### HTTP Method Analysis:
- `RequestHelper::getMethod()`: Get the HTTP request method (GET, POST, etc.)
- `RequestHelper::isMethod($method)`: Check if request method matches given method
- `RequestHelper::isGet()`: Check if request is GET
- `RequestHelper::isPost()`: Check if request is POST
- `RequestHelper::isPut()`: Check if request is PUT
- `RequestHelper::isDelete()`: Check if request is DELETE
- `RequestHelper::isHead()`: Check if request is HEAD
- `RequestHelper::isOptions()`: Check if request is OPTIONS
- `RequestHelper::isPatch()`: Check if request is PATCH

##### Request Type Detection:
- `RequestHelper::isAjax()`: Check if request is AJAX/XMLHttpRequest
- `RequestHelper::isApi()`: Check if request is likely an API request
- `RequestHelper::isMobile()`: Check if request is from mobile device
- `RequestHelper::isBot()`: Check if request is from bot/crawler

##### Client Information:
- `RequestHelper::getClientIp($trustProxies = true)`: Get client IP address with proxy support
- `RequestHelper::getUserAgent()`: Get user agent string
- `RequestHelper::getReferrer()`: Get referrer URL
- `RequestHelper::getProtocol()`: Get request protocol (HTTP/1.1, HTTP/2, etc.)
- `RequestHelper::getPort()`: Get request port
- `RequestHelper::getHost()`: Get host name

##### Content Analysis:
- `RequestHelper::getContentType()`: Get request content type
- `RequestHelper::isContentType($type)`: Check if content type matches
- `RequestHelper::isJson()`: Check if request has JSON content type
- `RequestHelper::isXml()`: Check if request has XML content type
- `RequestHelper::getContentLength()`: Get content length
- `RequestHelper::getAcceptedLanguages()`: Get accepted languages from Accept-Language header

##### Header Management:
- `RequestHelper::getHeader($name, $default = null)`: Get specific request header
- `RequestHelper::hasHeader($name)`: Check if header exists
- `RequestHelper::getAllHeaders()`: Get all request headers

##### Security and Validation:
- `RequestHelper::isLegitimate()`: Basic security check for legitimate requests
- `RequestHelper::getRequestTime()`: Get request timestamp
- `RequestHelper::isWithinRateLimit($maxRequests, $timeWindow, $identifier = null)`: Basic rate limiting

##### Utility Methods:
- `RequestHelper::getRequestInfo()`: Get comprehensive request information array
- `RequestHelper::setTrustedProxyHeaders($headers)`: Set trusted proxy headers
- `RequestHelper::getTrustedProxyHeaders()`: Get current trusted proxy headers

#### Usage Examples:
```php
use AndreasGlaser\Helpers\Http\RequestHelper;

// Environment detection
$isCli = RequestHelper::isCli(); // true if running in command line
$isHttps = RequestHelper::isHttps(); // true if using HTTPS
$isSecure = RequestHelper::isSecure(); // true if HTTPS or localhost

// HTTP method detection
$method = RequestHelper::getMethod(); // "GET", "POST", etc.
$isPost = RequestHelper::isPost(); // true if POST request
$isAjax = RequestHelper::isAjax(); // true if AJAX request

// Client information
$clientIp = RequestHelper::getClientIp(); // Client IP with proxy support
$userAgent = RequestHelper::getUserAgent(); // User agent string

// Content analysis
$isJson = RequestHelper::isJson(); // true if JSON content type
$authHeader = RequestHelper::getHeader('Authorization'); // Get specific header

// Practical examples
function requireHttps() {
    if (!RequestHelper::isHttps() && !RequestHelper::isLocalhost()) {
        header('Location: https://' . RequestHelper::getHost() . $_SERVER['REQUEST_URI']);
        exit;
    }
}
```

#### URL Helper (`Http/UrlHelper.php`)
Comprehensive URL manipulation, validation, and generation utilities for HTTP requests.

##### Current URL/URI Methods:
- `UrlHelper::protocolHostPort()`: Get protocol, host, and port string based on server configuration
- `UrlHelper::query($parameters = null, $mergeGetVariables = true)`: Build query string from parameters with optional $_GET merging
- `UrlHelper::currentUrl($includeQuery = true, $urlEncode = false)`: Get current full URL with optional query string and encoding
- `UrlHelper::currentUri($includeQueryParams = true, $encode = false)`: Get current URI with optional query parameters and encoding

##### URL Parsing and Validation:
- `UrlHelper::isValidUrl($url, $allowedSchemes = ['http', 'https'])`: Validate URL with configurable allowed schemes
- `UrlHelper::parseUrl($url)`: Parse URL components into structured array
- `UrlHelper::buildUrl($components)`: Build URL from component array
- `UrlHelper::isStandardPort($scheme, $port)`: Check if port is standard for given scheme

##### URL Manipulation:
- `UrlHelper::addQueryParams($url, $params, $encode = true)`: Add or modify query parameters in URL
- `UrlHelper::removeQueryParams($url, $paramsToRemove)`: Remove specific query parameters from URL
- `UrlHelper::changeScheme($url, $scheme)`: Change URL scheme (e.g., HTTP to HTTPS)
- `UrlHelper::normalize($url)`: Normalize URL by cleaning up common issues

##### Path Manipulation:
- `UrlHelper::normalizePath($path)`: Normalize URL path by resolving . and .. segments
- `UrlHelper::joinPaths(...$segments)`: Join multiple path segments into single path
- `UrlHelper::getDirectory($path)`: Get directory path from URL path
- `UrlHelper::getFilename($path)`: Get filename from URL path
- `UrlHelper::getExtension($path)`: Get file extension from URL path

##### Domain and Host Utilities:
- `UrlHelper::getDomain($url)`: Extract domain from URL
- `UrlHelper::getSubdomain($url, $levels = 2)`: Extract subdomain with configurable root domain levels
- `UrlHelper::getRootDomain($url, $levels = 2)`: Get root domain with configurable levels
- `UrlHelper::isSameDomain($url1, $url2)`: Check if two URLs have same domain

##### Encoding and Decoding:
- `UrlHelper::encode($string)`: URL encode string with RFC 3986 compliance
- `UrlHelper::decode($string)`: URL decode string
- `UrlHelper::encodePath($path)`: Encode only path component of URL
- `UrlHelper::encodeQuery($params, $rfc3986 = true)`: Encode query string parameters

##### URL Conversion and Transformation:
- `UrlHelper::toAbsolute($relativeUrl, $baseUrl)`: Convert relative URL to absolute
- `UrlHelper::toRelative($absoluteUrl, $baseUrl)`: Convert absolute URL to relative

##### Utility Methods:
- `UrlHelper::currentUrlWithModifications($queryModifications = [], $queryRemovals = [])`: Get current URL with query modifications
- `UrlHelper::isSecureUrl($url)`: Check if URL uses HTTPS scheme
- `UrlHelper::getStandardPort($scheme)`: Get standard port for scheme
- `UrlHelper::sanitize($url, $allowedSchemes = ['http', 'https'])`: Sanitize URL by removing dangerous protocols
- `UrlHelper::modifiedQuery($params = [], $remove = [])`: Generate query string from current URL with modifications

##### Constants:
- URL schemes: `SCHEME_HTTP`, `SCHEME_HTTPS`, `SCHEME_FTP`, `SCHEME_SFTP`, `SCHEME_FILE`
- Standard ports array: `STANDARD_PORTS` with common protocol ports

#### Usage Examples:
```php
use AndreasGlaser\Helpers\Http\UrlHelper;

// Current URL/URI operations
$currentUrl = UrlHelper::currentUrl(); // Full current URL with query string
$currentUri = UrlHelper::currentUri(); // Current URI path with query params
$protocolHost = UrlHelper::protocolHostPort(); // "https://example.com:443"

// Query string building
$query = UrlHelper::query(['page' => 2, 'sort' => 'name']); // "page=2&sort=name"
$mergedQuery = UrlHelper::query(['new' => 'param'], true); // Merges with $_GET

// URL validation and parsing
$isValid = UrlHelper::isValidUrl('https://example.com'); // true
$components = UrlHelper::parseUrl('https://user:pass@example.com:8080/path?query=1#fragment');
// Returns: ['scheme' => 'https', 'host' => 'example.com', 'port' => 8080, ...]

$rebuiltUrl = UrlHelper::buildUrl($components); // Rebuilds URL from components

// URL manipulation
$withParams = UrlHelper::addQueryParams('https://example.com', ['foo' => 'bar']);
// Result: "https://example.com?foo=bar"

$withoutParams = UrlHelper::removeQueryParams('https://example.com?foo=bar&baz=qux', ['foo']);
// Result: "https://example.com?baz=qux"

$httpsUrl = UrlHelper::changeScheme('http://example.com', 'https');
// Result: "https://example.com"

$normalized = UrlHelper::normalize('https://example.com//path/../other/');
// Result: "https://example.com/other/"

// Path manipulation
$cleanPath = UrlHelper::normalizePath('/path/../to/./file.txt'); // "/to/file.txt"
$joinedPath = UrlHelper::joinPaths('path', 'to', 'file.txt'); // "path/to/file.txt"
$directory = UrlHelper::getDirectory('/path/to/file.txt'); // "/path/to"
$filename = UrlHelper::getFilename('/path/to/file.txt'); // "file.txt"
$extension = UrlHelper::getExtension('/path/to/file.txt'); // "txt"

// Domain operations
$domain = UrlHelper::getDomain('https://sub.example.com/path'); // "sub.example.com"
$subdomain = UrlHelper::getSubdomain('https://blog.example.com'); // "blog"
$rootDomain = UrlHelper::getRootDomain('https://blog.example.com'); // "example.com"
$sameDomain = UrlHelper::isSameDomain('https://example.com', 'http://example.com'); // true

// Encoding and decoding
$encoded = UrlHelper::encode('hello world!'); // "hello%20world%21"
$decoded = UrlHelper::decode('hello%20world%21'); // "hello world!"
$encodedPath = UrlHelper::encodePath('/path with spaces/file.txt');
$encodedQuery = UrlHelper::encodeQuery(['key' => 'value with spaces']);

// URL conversion
$absolute = UrlHelper::toAbsolute('../other/page.html', 'https://example.com/path/current.html');
// Result: "https://example.com/other/page.html"

$relative = UrlHelper::toRelative('https://example.com/other/page.html', 'https://example.com/path/');
// Result: "../other/page.html"

// Utility methods
$isSecure = UrlHelper::isSecureUrl('https://example.com'); // true
$standardPort = UrlHelper::getStandardPort('https'); // 443
$sanitized = UrlHelper::sanitize('javascript:alert("xss")'); // Returns null (dangerous)

// Current URL modifications
$modifiedUrl = UrlHelper::currentUrlWithModifications(['page' => 3], ['sort']);
// Adds page=3 and removes sort parameter from current URL

$modifiedQuery = UrlHelper::modifiedQuery(['filter' => 'active'], ['old_param']);
// Creates query string with modifications

// Practical examples
function buildPaginationUrl($page) {
    return UrlHelper::currentUrlWithModifications(['page' => $page], ['offset']);
}

function redirectToHttps() {
    if (!UrlHelper::isSecureUrl(UrlHelper::currentUrl())) {
        $httpsUrl = UrlHelper::changeScheme(UrlHelper::currentUrl(), 'https');
        header("Location: $httpsUrl");
        exit;
    }
}

function buildApiUrl($endpoint, $params = []) {
    $baseUrl = 'https://api.example.com';
    $fullUrl = UrlHelper::joinPaths($baseUrl, 'v1', $endpoint);
    
    if ($params) {
        $fullUrl = UrlHelper::addQueryParams($fullUrl, $params);
    }
    
    return $fullUrl;
}

function cleanUserUrl($userInput) {
    // Sanitize and validate user-provided URL
    $sanitized = UrlHelper::sanitize($userInput);
    
    if (!$sanitized || !UrlHelper::isValidUrl($sanitized)) {
        throw new InvalidArgumentException('Invalid URL provided');
    }
    
    return UrlHelper::normalize($sanitized);
}

// URL comparison and analysis
function analyzeUrl($url) {
    $components = UrlHelper::parseUrl($url);
    
    return [
        'domain' => UrlHelper::getDomain($url),
        'subdomain' => UrlHelper::getSubdomain($url),
        'is_secure' => UrlHelper::isSecureUrl($url),
        'port' => $components['port'] ?? UrlHelper::getStandardPort($components['scheme']),
        'path_parts' => explode('/', trim($components['path'] ?? '', '/'))
    ];
}
```

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

#### Usage Examples:
```php
use AndreasGlaser\Helpers\Html\FormHelper;
use AndreasGlaser\Helpers\Html\AttributesHelper;

// Basic form creation
echo FormHelper::open('/submit', 'POST'); // <form action="/submit" method="POST">
echo FormHelper::close(); // </form>

// Text inputs
echo FormHelper::text('username', 'john_doe'); // <input type="text" name="username" value="john_doe" />
echo FormHelper::password('password'); // <input type="password" name="password" />
echo FormHelper::email('email', 'john@example.com'); // <input type="email" name="email" value="john@example.com" />

// Specialized inputs
echo FormHelper::number('age', 25); // <input type="number" name="age" value="25" />
echo FormHelper::date('birthdate', '1990-05-15'); // <input type="date" name="birthdate" value="1990-05-15" />
echo FormHelper::range('volume', 75, 0, 100); // <input type="range" name="volume" value="75" min="0" max="100" />

// Select dropdown
$options = ['us' => 'United States', 'ca' => 'Canada'];
echo FormHelper::select('country', $options, 'us');
// <select name="country"><option value="us" selected>United States</option>...</select>

// Checkboxes and radio buttons
echo FormHelper::checkbox('newsletter', '1', true); // <input type="checkbox" name="newsletter" value="1" checked />
echo FormHelper::radio('gender', 'M', true); // <input type="radio" name="gender" value="M" checked />

// Complete form example
echo FormHelper::open('/register', 'POST');
echo FormHelper::label('Name:', 'name');
echo FormHelper::text('name', '', AttributesHelper::f(['class' => 'form-control', 'required' => true]));
echo FormHelper::submit('register', 'Sign Up', AttributesHelper::f(['class' => 'btn btn-primary']));
echo FormHelper::close();
```

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

#### Usage Examples:
```php
use AndreasGlaser\Helpers\Validate\NetworkHelper;

// IP address validation
$validIPv4 = NetworkHelper::isValidIPv4('192.168.1.1'); // true
$validIPv6 = NetworkHelper::isValidIPv6('2001:db8::1'); // true
$invalidIP = NetworkHelper::isValidIPv4('999.999.999.999'); // false

// General IP validation with options
$publicIP = NetworkHelper::isValidIP('8.8.8.8'); // true
$privateIP = NetworkHelper::isValidIP('192.168.1.1', true); // true (allow private)
$noPrivate = NetworkHelper::isValidIP('192.168.1.1', false); // false (disallow private)

// Port validation
$validPort = NetworkHelper::isValidPort(80); // true
$systemPort = NetworkHelper::isValidPort(22, true); // true (allow system ports)
$userPort = NetworkHelper::isValidPort(8080, false, true); // true (user ports 1024-49151)

// Domain validation
$validDomain = NetworkHelper::isValidDomain('example.com'); // true
$singleLabel = NetworkHelper::isValidDomain('localhost', true); // true (allow single label)

// MAC address validation
$macColon = NetworkHelper::isValidMac('00:1B:44:11:3A:B7'); // true
$macHyphen = NetworkHelper::isValidMac('00-1B-44-11-3A-B7'); // true

// Common port lookup
$httpPort = NetworkHelper::getCommonPort('http'); // 80
$httpsPort = NetworkHelper::getCommonPort('https'); // 443
$sshPort = NetworkHelper::getCommonPort('ssh'); // 22

// DNS operations
$dnsRecords = NetworkHelper::getDnsRecords('example.com', 'A');
$hasMX = NetworkHelper::isValidMxRecord('gmail.com'); // true

// Port connectivity testing
$isOpen = NetworkHelper::isPortOpen('google.com', 80, 3.0); // true
$openPorts = NetworkHelper::getOpenPorts('example.com', [22, 80, 443], 2.0);

// Service name lookup
$httpService = NetworkHelper::getServiceByPort(80); // "http"
$httpsService = NetworkHelper::getServiceByPort(443); // "https"

// Practical example: Validate server configuration
function validateServerConfig($config) {
    if (!NetworkHelper::isValidIP($config['host'])) {
        throw new InvalidArgumentException('Invalid host IP address');
    }
    
    if (!NetworkHelper::isValidPort($config['port'])) {
        throw new InvalidArgumentException('Invalid port number');
    }
    
    if (!NetworkHelper::isPortOpen($config['host'], $config['port'], 5.0)) {
        throw new RuntimeException('Cannot connect to specified host and port');
    }
    
    return true;
}

// Email domain validation
function validateEmailDomain($email) {
    $domain = substr(strrchr($email, "@"), 1);
    
    if (!NetworkHelper::isValidDomain($domain)) {
        return false;
    }
    
    return NetworkHelper::isValidMxRecord($domain);
}
```

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

#### Usage Examples:
```php
use AndreasGlaser\Helpers\Validate\Expect;

// Basic type validation - throws UnexpectedTypeException if validation fails
try {
    Expect::int(42); // OK
    Expect::str("Hello"); // OK
    Expect::bool(true); // OK
    
    Expect::int("42"); // Exception - string, not integer
} catch (UnexpectedTypeException $e) {
    echo "Expected integer, got string";
}

// Numeric validation (accepts int, float, or numeric string)
Expect::numeric(42); // OK
Expect::numeric(3.14); // OK
Expect::numeric("123"); // OK
Expect::numeric("45.67"); // OK

// Array and object validation
Expect::arr([1, 2, 3]); // OK
Expect::obj(new stdClass()); // OK

// Callable validation
Expect::isCallable('strlen'); // OK
Expect::isCallable(function() {}); // OK

// Scalar validation (int, float, string, or bool)
Expect::scalar(42); // OK
Expect::scalar("hello"); // OK

// Practical usage in functions
function processUser($userData) {
    Expect::arr($userData);
    Expect::str($userData['name']);
    Expect::int($userData['age']);
    Expect::bool($userData['active']);
    
    return "Processing user: " . $userData['name'];
}

function calculateInterest($principal, $rate, $time) {
    Expect::numeric($principal);
    Expect::numeric($rate);
    Expect::numeric($time);
    Expect::finite($principal);
    Expect::finite($rate);
    
    return $principal * $rate * $time;
}

// Configuration validation
function loadConfig($configData) {
    Expect::arr($configData);
    
    if (isset($configData['debug'])) {
        Expect::bool($configData['debug']);
    }
    
    if (isset($configData['timeout'])) {
        Expect::int($configData['timeout']);
    }
    
    return $configData;
}
```

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

#### Usage Examples:
```php
use AndreasGlaser\Helpers\Validate\IOExpect;

// Basic file validation
IOExpect::exists('/path/to/file.txt'); // Throws IOException if file doesn't exist
IOExpect::isFile('/path/to/document.pdf'); // Throws IOException if not a file
IOExpect::isDir('/path/to/directory'); // Throws IOException if not a directory

// Permission validation
IOExpect::isReadable('/path/to/file.txt'); // Throws IOException if not readable
IOExpect::isWritable('/path/to/file.txt'); // Throws IOException if not writable

// File size validation
IOExpect::hasMinSize('/path/to/file.txt', 1024); // Throws IOException if file < 1KB
IOExpect::hasMaxSize('/path/to/file.txt', 1048576); // Throws IOException if file > 1MB

// File extension validation
IOExpect::hasExtension('/path/to/image.jpg', 'jpg'); // Throws IOException if wrong extension

// Practical usage
function validateUpload($filePath) {
    IOExpect::exists($filePath);
    IOExpect::isFile($filePath);
    IOExpect::hasMaxSize($filePath, 5242880); // 5MB max
    IOExpect::hasAllowedExtension($filePath, ['jpg', 'png', 'pdf']);
    
    return true;
}
```


## Run tests

```bash
composer install
./bin/phpunit
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