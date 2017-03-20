# php-helpers
A simple php library of various helper functions and classes.

## Installation
```shell
composer require andreas-glaser/php-helpers @stable
```

## Usage
```php
<?php

namespace TestApp;

use AndreasGlaser\Helpers\StringHelper;

$myString = 'This is great';
var_dump(StringHelper::startsWith($myString, 'This is')); // true