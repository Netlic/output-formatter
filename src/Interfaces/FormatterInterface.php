<?php

namespace OutputFormat\Interfaces;

interface FormatterInterface
{
    /**
     * @param string $format
     * @return mixed
     */
    public function translateFormat(string $format);

    /**
     * @return string
     */
    public function type() :string;
}