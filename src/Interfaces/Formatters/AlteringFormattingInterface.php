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

    public function translateValue($value);
}