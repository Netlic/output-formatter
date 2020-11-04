<?php

use OutputFormat\Outputter;

if (!function_exists('translateFormat')) {
    /**
     * Translates format to code
     * @param string $format
     * @return string
     */
    function translateFormat(string $format) :string {
        return Outputter::config('translation-formats.' . $format);
    };
}

if (!function_exists('getDefaultConfig')) {
    /**
     * Reads the content of the default config file
     * @return array
     */
    function getDefaultConfig() :array {
        return require_once 'config.php';
    };
}