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
}