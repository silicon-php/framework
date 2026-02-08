<?php

namespace Silicon\DI;

final class ContainerManager
{
    private static ?Container $container = null;

    public static function get(): Container
    {
        if (self::$container === null) {
            self::$container = ContainerFactory::create();
        }

        return self::$container;
    }
}
