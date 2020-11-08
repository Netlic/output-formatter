<?php

namespace OutputFormat\Formats;

use OutputFormat\Interfaces\FormatterInterface;

class FinalFormatter extends AlteringFormats implements \ArrayAccess
{
    private const DECORATIVE_FORMATTER = 'decorative';
    private const ALTERING_FORMATTER = 'altering';

    /** @var array */
    protected array $addedDecorations = [];

    /** @var string */
    protected string $text = '';

    /** @var string[] */
    protected array $formats = [];

    /** @var FormatterInterface[] */
    protected array $formatters = [];

    /** @var bool */
    protected bool $preserveFormatting = false;

    /**
     * @param array $formatters
     * @return FinalFormatter
     */
    public function addFormatters(array $formatters) :self
    {
        $this->formats = array_merge($this->formats, $formatters);

        return $this;
    }

    /**
     * @param string $formatter
     * @param $format
     * @throws \Exception
     */
    public function addDecorative(string $formatter, $format)
    {
        $formatterInstance = $this->getFormatter($formatter);
        $this->addedDecorations[] = $formatterInstance($format);
    }

    /**
     * @param string $formatter
     * @param string|null $value
     */
    public function addAltering(string $formatter, string $value = null)
    {
        $merged = $formatter;
        if (!empty($value)) {
            $merged = sprintf('%s:%s', $formatter, $value);
        }
        $this->formats[] = $merged;
    }

    /**
     * @param $value
     * @return string
     * @throws \Exception
     */
    public function translateValue($value): string
    {
        foreach ($this->formats as $format) {
            if (strpos($format, ':') !== false) {
                list($formatter, $formatValue) = explode(':', $format);
            } else {
                $formatter = $format;
                $formatValue = null;
            }

            $formatterInstance = $this->getFormatter($formatter);
            if ($formatterInstance->type() === self::DECORATIVE_FORMATTER) {
                $decorationCode = $formatterInstance($formatValue);
                if (!in_array($decorationCode, $this->addedDecorations)) {
                    $this->addedDecorations[] = $decorationCode;
                }
            } else {
                $value = $formatterInstance($formatValue, $value);
            }
        }

        return $this->wrap($value);
    }

    /**
     * @inheritDoc
     */
    public function translateFormat(string $format)
    {
        return $format;
    }

    /**
     * @param bool $preserveFormatting
     */
    public function setPreserveFormatting(bool $preserveFormatting)
    {
        $this->preserveFormatting = $preserveFormatting;
    }

    public function offsetExists($offset)
    {
        return !empty($this->formatters[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed|FormatterInterface|null
     * @throws \Exception
     */
    public function offsetGet($offset)
    {
        if (empty($this->formatters[$offset])) {
            $formatterClassName = config('formatters.' . $offset);
            if (is_array($formatterClassName)) {
                throw new \Exception('No class defined for formatter: ' . $offset);
            }
            $this->formatters[$offset] = new $formatterClassName;
        }

        return $this->formatters[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws \Exception
     */
    public function offsetSet($offset, $value)
    {
        if (!is_object($value)) {
            throw new \Exception('The formatter must be an object');
        }

        $isFormatter = in_array(FormatterInterface::class, class_implements($value));
        if (!$isFormatter) {
            throw new \Exception('The class of the provided instance does not implement formatter interface: ' . get_class($value));
        }

        $this->formatters[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if (!empty($this->formatters[$offset])) {
            unset($this->formatters[$offset]);
        }
    }

    /**
     * Gets the formatter instance
     * @param string $formatter
     * @return FormatterInterface|null
     * @throws \Exception
     */
    protected function getFormatter(string $formatter)
    {
        return $this[$formatter];
    }

    /**
     * @param string $text
     * @return string
     */
    private function composeTag(string $text) :string
    {
        $delimiter = config('escape-tag.delimiter');
        $textModes = implode($delimiter, $this->addedDecorations);
        $begin = config('escape-tag.begin');
        $end = config('escape-tag.end');

        $opening = sprintf('%s%s%s', $begin, $textModes, $end);
        $closing = '';
        if (!$this->preserveFormatting) {
            $default = config('translation-formats.default');
            $closing = sprintf('%s%s%s', $begin, $default, $end);
        }

        return $opening . $text . $closing;
    }

    /**
     * @param string $value
     * @return string
     */
    private function wrap(string $value)
    {
        return $this->composeTag($value);
    }
}