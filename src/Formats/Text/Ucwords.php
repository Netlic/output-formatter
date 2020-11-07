<?php

namespace OutputFormat\Formats\Text;

use OutputFormat\Formats\AlteringFormats;

class Ucwords extends AlteringFormats
{
    /**
     * @inheritDoc
     */
    public function translateValue($value): string
    {
        return ucwords($value);
    }

    /**
     * @inheritDoc
     */
    public function translateFormat(string $format)
    {
        return $format;
    }
}