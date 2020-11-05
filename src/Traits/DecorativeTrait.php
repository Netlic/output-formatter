<?php

namespace OutputFormat\Traits;

trait DecorativeTrait
{
    /**
     * @param string $color
     * @return self
     * @throws \Exception
     */
    public function textColor(string $color) :self
    {
        $this->finalFormatter->addDecoration('color', $color);

        return $this;
    }

    public function backgroundColor() :self
    {
        return $this;
    }
}