<?php

namespace OutputFormat\Formats;

use OutputFormat\Interfaces\FormatterInterface;
use OutputFormat\Interfaces\Formatters\DecorativeFormatterInterface;

abstract class DecorativeFormats extends Formats implements FormatterInterface, DecorativeFormatterInterface
{
    public function restoreDefault()
    {

    }

    public function __toString() :string
    {
        return $this->format;
    }

    public function __invoke(string $format = null)
    {
        if (!empty($format)) {
            $this->setFormat($format);
        }

        return (string)$this;
    }

    /**
     * @param string $rawFormat
     * @return string
     */
    public function translateFormat(string $rawFormat) :string
    {
        return translateFormat($rawFormat);
    }

    /**
     * @inheritDoc
     */
    public function type() :string
    {
        return 'decorative';
    }
}