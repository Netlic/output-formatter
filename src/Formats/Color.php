<?php

namespace OutputFormat\Formats;

class Color extends DecorativeFormats
{
    /**
     * @param string $color
     * @return Color
     */
    public function setColor(string $color) :Color
    {
        return $this->setFormat($color);
    }
}