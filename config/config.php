<?php

use OutputFormat\Formats\Color;
use OutputFormat\Formats\DecorativeFormats;
use OutputFormat\Formats\FinalFormatter;
use OutputFormat\Formats\Text\Lowercase;
use OutputFormat\Output\Stdout;

return [
    'translation-formats' => [
        'red' => "31",
        'green' => "32",
        'yellow' => "33",
        'blue' => "34",
        'default-color' => "0"
    ],

    'escape-tag' => [
        'begin' => "\033[",
        'end' => "m",
        'delimiter' => ";"
    ],

    'output' => Stdout::class,

    'formatters' => [
        'color' => Color::class,
        'text-features' => DecorativeFormats::class,
        'final-formatter' => FinalFormatter::class,
        'lowercase' => Lowercase::class
    ]
];
