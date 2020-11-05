<?php

namespace OutputFormat\Output;

use OutputFormat\Interfaces\OutputInterface;

class Stdout implements OutputInterface
{
    /** @var string */
    protected string $outputString;

    /**
     * @param string $outputString
     * @return Stdout
     */
    public function setOutputString(string $outputString) :Stdout
    {
        $this->outputString = $outputString;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function printOutput(string $output = null) :bool
    {
        return (bool)fwrite(STDOUT, (string)$output);
    }
}