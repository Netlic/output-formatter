# Output Formatter

Console output simplified.

## Requirements
 - PHP 7.4
 
## Installation
## Configuration
Please take a look at a [configuration file.](/config/config.php). Any configuration value can be accessed via `config` 
helper function, e.g.:
```php
$translationFormats = config('translation-formats');

/* For accessing nested values '.' character can be used, following will return 
foreground red color code */ 
$redColorCode = config('translation-formats.colors.red');
```
Every configuration value can be overriden by creating array using the same keys
as used in the original config file and passing it as a parameter when initializing library. For example:
```php
use OutputFormat\Outputter;

$myConfigArray = ['translation-formats' => [
    'colors' => [
        'red' => '15'
    ]
]];

$outputter = Outputter::init($myConfigArray);
``` 
## Usage
#### Initialize the library
```php
use OutputFormat\Outputter;

//throws an exception 
$outputter = Outputter::init();
```