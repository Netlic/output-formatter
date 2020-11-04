<?php

namespace OutputFormat\Colors;

use OutputFormat\Formats\Formats;

class Color extends Formats
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