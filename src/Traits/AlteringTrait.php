<?php

namespace OutputFormat\Traits;

trait AlteringTrait
{
    public function lowercase()
    {
        $this->finalFormatter->addAltering('lowercase');

        return $this;
    }
}