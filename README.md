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

/* For accessing nested values '.' character can be used, 
following will return foreground red color code */ 
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
#### Add formatting
```php

//changes foreground color
/** @var OutputFormat\Outputter $outputter*/
$outputter->color('red');

//using multiple formatters is also available by chaining
$outputter->color('red')->lowercase()->backgroundColor('yellow');

//library also supports 88/256 coloring,
//for this case just pass a number of color instead of its name
$outputter->color('50')->backgroundColor('200');
```
#### Print output
```php
/** For printing output the config value 'output' 
 class is instantiated and invoked */

/** @var OutputFormat\Outputter $outputter */
$outputter->print('Lorem ipsum');

//prints line
$outputter->printLine('Lorem ipsum');

//text formatting can by applied also on printing
$outputter->printLine('Lorem ipsum', ['color:yellow', 'lowercase']);

//to preserve formatting just set the last parameter to true
$outputter->printLine('Lorem ipsum', ['color:yellow', 'lowercase'], true);
```
#### Current formatter list
```php
use OutputFormat\Outputter;

/**
 * @method Outputter color(string $color)
 * @method Outputter backgroundColor(string $color)
 * @method Outputter lowercase()
 * @method Outputter capitalizeWords()
 * @method Outputter textFeature(string $feature)
 */

/* Print method accepts referencing to formatter in kebab-case
 eg. 'capitalize-words'
```
#### Modifying formatters
Any formatter can be easily replaced by your custom class.
Simply rewrite class reference under the desired config key. This way you can also extend the list
of existing formatters. A good practice after doing so would be extending the base class
`OutputFormat\OutputFormat` and update the PHP doc of the class.