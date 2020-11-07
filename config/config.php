<?php

use OutputFormat\Formats\BackgroundColor;
use OutputFormat\Formats\Color;
use OutputFormat\Formats\DecorativeFormats;
use OutputFormat\Formats\FinalFormatter;
use OutputFormat\Formats\Text\Lowercase;
use OutputFormat\Formats\Text\Ucwords;
use OutputFormat\Formats\TextFeatures;
use OutputFormat\Output\Stdout;

return [
    'translation-formats' => [
        'colors' => [
            'black' => "30",
            'red' => "31",
            'green' => "32",
            'yellow' => "33",
            'blue' => "34",
            'magenta' => "35",
            'cyan' => "36",
            'light-gray' => "37",
            'dark-gray' => "90",
            'light-red' => "91",
            'light-green' => "92",
            'light-yellow' => "93",
            'light-blue' => "94",
            'light-magenta' => "95",
            'light-cyan' => "96",
            'more-color-prefix' => "38;5;"
        ],
        'text-features' => [
            'bold' => "1",
            'dim' => "2",
            'underline' => "4",
            'blink' => "5",
            'reverse' => "7",
            'hidden' => "8"
        ],
        'background-colors' => [
            'black' => "40",
            'red' => "41",
            'green' => "42",
            'yellow' => "43",
            'blue' => "44",
            'magenta' => "45",
            'cyan' => "46",
            'light-gray' => "47",
            'dark-gray' => "100",
            'light-red' => "101",
            'light-green' => "102",
            'light-yellow' => "103",
            'light-blue' => "104",
            'light-magenta' => "105",
            'light-cyan' => "106",
            'light-white' => "107",
            'more-color-prefix' => "48;5;"
        ],
        'default' => "0",

    ],

    'escape-tag' => [
        'begin' => "\033[",
        'end' => "m",
        'delimiter' => ";"
    ],

    'output' => Stdout::class,

    'formatters' => [
        'color' => Color::class,
        'text-feature' => TextFeatures::class,
        'final-formatter' => FinalFormatter::class,
        'lowercase' => Lowercase::class,
        'capitalize-words' => Ucwords::class,
        'background-color' => BackgroundColor::class
    ]
];
