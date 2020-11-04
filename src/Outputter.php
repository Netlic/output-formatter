<?php

namespace OutputFormat;

use OutputFormat\Interfaces\OutputInterface;

class Outputter
{
    /** @var Outputter|null */
    private static ?Outputter $instance = null;

    /** @var array */
    protected array $config = [];
    
    /** @var OutputInterface */
    protected OutputInterface $output;

    /**
     * Outputter constructor.
     * @param array $config
     * @throws \Exception
     */
    public function __construct(array $config = [])
    {
        $this->config = $this->mergeConfig($config);
        $this->loadOutput();
    }

    public function setColor(string $color)
    {

    }

    /**
     * @param string $text
     * @param string|array $formats
     */
    public function print(string $text, $formats)
    {
        $this->output->printOutput();
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
     * @param string $configPath
     * @return array|string
     */
    public static function config(string $configPath = '')
    {
        if (self::$instance) {
            return self::$instance->getConfig($configPath);
        }

        return [];
    }

    /**
     * @param array $config
     * @return Outputter
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
        $outputClass = $this->getConfig('output');
        if (!in_array(OutputInterface::class, class_implements($outputClass))) {
            throw new \Exception(sprintf('Provided class \'%s\' is not an output', $outputClass));
        }
        $this->output = new $outputClass();
    }
}