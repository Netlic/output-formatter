<?php

namespace OutputFormat\Formats;

abstract class Formats
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

    public function restoreDefault()
    {

    }

    public function __toString() :string
    {
        return $this->format;
    }

    public function __invoke(string $format, string $text)
    {
        $this->format = $this->translateFormat($format);

        return (string)$this;
    }

    /**
     * @param string $rawFormat
     * @return string
     */
    protected function translateFormat(string $rawFormat) :string
    {
        return translateFormat($rawFormat);
    }
}