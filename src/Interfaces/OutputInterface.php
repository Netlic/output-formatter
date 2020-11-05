<?php

namespace OutputFormat\Interfaces;

interface OutputInterface
{
    /**
     * @param string|null $output
     * @return bool
     */
    public function printOutput(string $output = null) :bool;
}