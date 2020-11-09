<?php

namespace OutputFormat\Formats;

class Color extends DecorativeFormats
{
    /** @var string */
    protected string $configPath = 'colors';

    /**
     * @param string $color
     * @return Color
     */
    public function setColor(string $color) :Color
    {
        return $this->setFormat($color);
    }

    /**
     * @inheritDoc
     */
    public function translateFormat(string $rawFormat) :string
    {
        $replaced = preg_replace('/[^0-9]/', '', (string)$rawFormat);
        if (is_numeric($replaced)) {
            $moreColors = (config(sprintf('translation-formats.%s.more-color-prefix', $this->configPath)));

            return $moreColors . $replaced;
        }
        $rawFormat = sprintf('%s.%s', $this->configPath, $rawFormat);

        return parent::translateFormat($rawFormat);
    }
}