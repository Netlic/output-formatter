<?php

use OutputFormat\Outputter;

if (!function_exists('translateFormat')) {
    /**
     * Translates format to code
     * @param string $format
     * @return string
     */
    function translateFormat(string $format) :string {
        $code = config('translation-formats.' . $format);

        return is_array($code) ? $format : $code;
    };
}

if (!function_exists('getDefaultConfig')) {
    /**
     * Reads the content of the default config file
     * @return array
     */
    function getDefaultConfig() :array {
        return require 'config.php';
    };
}

if (!function_exists('config')) {
    /**
     * Gets the config merged values
     * @param string|null $configPath
     * @return array|string
     */
    function config(string $configPath = null) {
        return Outputter::config($configPath);
    };
}