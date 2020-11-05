<?php

namespace OutputFormat\Interfaces\Formatters;

interface AlteringFormattingInterface
{
    /**
     * Sets the value, that should be altered
     * @param mixed $value
     * @return AlteringFormattingInterface
     */
    public function setValue($value) :AlteringFormattingInterface;

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param $value
     * @return string
     */
    public function translateValue($value) :string;
}