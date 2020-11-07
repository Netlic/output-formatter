<?php

namespace OutputFormat\Formats;

use OutputFormat\Interfaces\Formatters\AlteringFormattingInterface;

abstract class AlteringFormats extends Formats implements AlteringFormattingInterface
{
    /** @var mixed */
    protected $value;

    /**
     * @inheritDoc
     */
    public function setValue($value): AlteringFormattingInterface
    {
        $this->value = $this->translateValue($value);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public function __toString() :string
    {
        return (string)$this->value;
    }

    public function __invoke(string $format = null, $value = null)
    {
        if (!empty($format)) {
            $this->setFormat($format);
        }

        if (!empty($value)) {
            $this->setValue($value);
        }

        return (string)$this;
    }

    /**
     * @inheritDoc
     */
    public function type() :string
    {
        return 'altering';
    }
}