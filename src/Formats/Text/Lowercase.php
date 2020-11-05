<?php

namespace OutputFormat\Formats\Text;

use OutputFormat\Formats\AlteringFormats;

class Lowercase extends AlteringFormats
{
    /**
     * @param mixed $value
     * @return string
     */
    public function translateValue($value) :string
    {
        try {
            return strtolower((string)$value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    public function translateFormat(string $format)
    {
        return '';
    }
}