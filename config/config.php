<?php

use OutputFormat\Colors\Color;
use OutputFormat\Formats\Formats;
use OutputFormat\Output\Stdout;

return [
    'translation-formats' => [
        'red' => '\e[31m',
        'green' => '\e[32m',
        'yellow' => '\e[33m',
        'blue' => '\e[34m'
    ],

    'output' => Stdout::class,

    'formatters' => [
        'color' => Color::class,
        'text-features' => Formats::class
    ]
];
