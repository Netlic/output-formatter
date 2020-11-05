<?php

namespace OutputFormat;

use OutputFormat\Formats\FinalFormatter;
use OutputFormat\Interfaces\FormatterInterface;
use OutputFormat\Interfaces\OutputInterface;
use OutputFormat\Traits\AlteringTrait;
use OutputFormat\Traits\DecorativeTrait;

class Outputter
{
    use DecorativeTrait, AlteringTrait;

    /** @var Outputter|null */
    private static ?Outputter $instance = null;

    /** @var array */
    protected array $config = [];
    
    /** @var OutputInterface */
    protected OutputInterface $output;

    /** @var FinalFormatter */
    protected FinalFormatter $finalFormatter;

    /**
     * Outputter constructor.
     * @param array $config
     * @throws \Exception
     */
    public function __construct(array $config = [])
    {
        $this->config = $this->mergeConfig($config);
        $this->loadOutput();
        $this->loadFinalFormatter();
    }



    /**
     * @param string $text
     * @param string|array $formats
     * @return bool
     * @throws \Exception
     */
    public function print(string $text, $formats = [])
    {
        if (!is_array($formats)) {
            $formats = [$formats];
        }
        $finalFormatter = $this->finalFormatter->addFormatters($formats);

        return $this->output->printOutput($finalFormatter(null, $text));
    }

    /**
     * @param string $text
     * @param array $formats
     * @return bool
     * @throws \Exception
     */
    public function printLine(string $text, $formats = [])
    {
        return $this->print($text . PHP_EOL, $formats);
    }

    /**
     * @param string|null $configPath
     * @return array|string
     */
    public function getConfig(string $configPath = null)
    {
        $configValue = $this->config;
        if (!empty($configPath)) {
            $configPathArray = explode('.', $configPath);
            foreach($configPathArray as $part) {
                if (empty($configValue[$part])) {
                    return $configValue;
                }
                $configValue = $configValue[$part];
            }
        }

        return $configValue;
    }

    /**
     * @param string|null $configPath
     * @return array|string
     */
    public static function config(string $configPath = null)
    {
        if (self::$instance) {
            return self::$instance->getConfig($configPath);
        }

        return [];
    }

    /**
     * @param array $config
     * @return Outputter
     * @throws \Exception
     */
    public static function init(array $config = []) :Outputter
    {
        self::$instance = new static($config);

        return self::$instance;
    }

    /**
     * Merge config with replacing old values in the default
     * @param array $config
     * @param array $merged
     * @return array
     */
    protected function mergeConfig(array $config, array $merged = [])
    {
        $merged = empty($merged) ? getDefaultConfig() : $merged;
        foreach ($config as $key => &$value) {
            if (is_array($value) && !empty($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->mergeConfig($value, $merged[$key]);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }

    /**
     * @throws \Exception
     */
    protected function loadOutput()
    {
        $class = $this->getAndCheckClassFromConfig('output', OutputInterface::class);
        $this->output = new $class();
    }

    /**
     * @throws \Exception
     */
    protected function loadFinalFormatter()
    {
        $class = $this->getAndCheckClassFromConfig('formatters.final-formatter', FormatterInterface::class);
        $this->finalFormatter = new $class();
    }

    /**
     * @param string $classPath
     * @param string $implements
     * @return array|string
     * @throws \Exception
     */
    private function getAndCheckClassFromConfig(string $classPath, string $implements)
    {
        $class = $this->getConfig($classPath);
        if (!in_array($implements, class_implements($class))) {
            throw new \Exception(sprintf('Provided class \'%s\' is not required interface \'%s\'', $class, $implements));
        }

        return $class;
    }
}