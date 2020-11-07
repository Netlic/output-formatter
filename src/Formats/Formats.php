<?php

namespace OutputFormat\Formats;

use OutputFormat\Interfaces\FormatterInterface;

abstract class Formats implements FormatterInterface
{
    /** @var string */
    protected string $format;

    /**
     * @param string $format
     * @return $this
     */
    public function setFormat(string $format) :Formats
    {
        $this->format = $this->translateFormat($format);

        return $this;
    }
}