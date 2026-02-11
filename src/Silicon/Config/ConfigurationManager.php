<?php

namespace Silicon\Config;

use Silicon\Kernel\Path;

class ConfigurationManager
{
    private static ?ConfigurationManager $configurationManager = null;
    private array $config = [];

    public function __construct()
    {
        // Framework default configurations
        $this->set('app', new AppConfig(require Path::config('app.php')));
        $this->set('http', new HttpConfig(require Path::config('http.php')));
        // TODO: Load user configurations and validations
    }

    public function set(string $key, mixed $value): void
    {
        $this->config[$key] = $value;
    }

    public function app(): AppConfig
    {
        return $this->config['app'];
    }

    public function http(): HttpConfig
    {
        return $this->config['http'];
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->config);
    }

    public static function getInstance(): ConfigurationManager
    {
        if (self::$configurationManager === null) {
            self::$configurationManager = new ConfigurationManager();
        }

        return self::$configurationManager;
    }
}
