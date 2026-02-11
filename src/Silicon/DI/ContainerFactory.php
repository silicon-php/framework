<?php

namespace Silicon\DI;

use Silicon\Http\CookieEncrypter;
use Silicon\Http\CookieSigner;
use Silicon\Logger\ConsoleLogger;
use Silicon\Logger\LoggerInterface;

class ContainerFactory
{
    public static function create(): Container
    {
        $container = new Container();

        // Register services and dependencies here
        // e.g., $container->set(ServiceInterface::class, new ServiceImplementation());

        $container->set(CookieSigner::class, fn (Container $container) => new CookieSigner(config()->http()->cookie->secret));
        $container->set(CookieEncrypter::class, fn (Container $container) => new CookieEncrypter(config()->http()->cookie->secret));

        $container->set(LoggerInterface::class, ConsoleLogger::class);

        return $container;
    }
}
