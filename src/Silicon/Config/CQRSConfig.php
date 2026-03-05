<?php

namespace Silicon\Config;

use Silicon\CQRS\CommandInterface;
use Silicon\CQRS\CommandRegister;

final class CQRSConfig
{
    /**
     * Summary of commands
     * @var CommandRegister[] $commands
     */
    public readonly array $commands;

    public function __construct(array $config)
    {
        $this->commands = $config['commands'] ?? [];
    }
}
