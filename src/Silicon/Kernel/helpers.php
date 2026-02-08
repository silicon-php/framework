
<?php

use Silicon\Config\ConfigurationManager;
use Silicon\DI\Container;
use Silicon\DI\ContainerManager;

if (!function_exists('container')) {
    function container(): Container
    {
        return ContainerManager::get();
    }
}

if (!function_exists('config')) {
    function config(): ConfigurationManager
    {
        return ConfigurationManager::getInstance();
    }
}
