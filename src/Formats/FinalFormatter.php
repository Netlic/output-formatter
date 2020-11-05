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
    protected array $formats;

    /** @var FormatterInterface[] */
    protected array $formatters = [];

    /**
     * @param array $formatters
     * @return FinalFormatter
     */
    public function addFormatters(array $formatters) :self
    {
        $this->formats = $formatters;

        return $this;
    }

    /**
     * @param string $formatter
     * @param $format
     * @throws \Exception
     */
    public function addDecoration(string $formatter, $format)
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

    /*public function addFormat(FormatterInterface $format, $value, $text)
    {
        //var_dump($value, $text);
        if ($format->type() == 'decorative') {
            $this->addedDecorations[] = $format($value);
        } else {
            $this->text = $format($value, $text);
        }

        var_dump($this->text);
    }*/

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
            if ($formatterInstance->type() === 'decorative') {
                $this->addedDecorations[] = $formatterInstance($formatValue);
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
     * Gets the formatter instance
     * @param string $formatter
     * @return FormatterInterface|null
     * @throws \Exception
     */
    public function getFormatter(string $formatter)
    {
        return $this[$formatter];
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
        // TODO: Implement offsetUnset() method.
    }

    /**
     * @return string
     */
    private function composeOpeningTag() :string
    {
        $delimiter = config('escape-tag.delimiter');
        $textModes = implode($delimiter, $this->addedDecorations);
        $begin = config('escape-tag.begin');
        $end = config('escape-tag.end');

        return sprintf('%s%s%s', $begin, $textModes, $end);
    }

    /**
     * @param string $value
     * @return string
     */
    private function wrap(string $value)
    {
        return sprintf('%s%s', $this->composeOpeningTag(), $value);
    }
}