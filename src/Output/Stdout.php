<?php

namespace OutputFormat\Output;

use OutputFormat\Interfaces\OutputInterface;

class Stdout implements OutputInterface
{
    /** @var string */
    protected string $outputString;

    public function printOutput()
    {
        return fwrite(STDOUT, $this->outputString);
    }
}