<?php

namespace OutputFormat\Formats;

class TextFeatures extends DecorativeFormats
{
    public function translateFormat(string $rawFormat): string
    {
        $rawFormat = 'text-features.' . $rawFormat;

        return parent::translateFormat($rawFormat);
    }
}