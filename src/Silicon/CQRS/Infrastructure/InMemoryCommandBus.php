<?php

namespace Silicon\CQRS\Infrastructure;

use Silicon\CQRS\CommandBusInterface;
use Silicon\CQRS\CommandHandlerInterface;
use Silicon\CQRS\CommandInterface;

class InMemoryCommandBus implements CommandBusInterface
{
    private array $handlers = [];

    public function register(CommandInterface $command, CommandHandlerInterface $handler): void
    {
        $this->handlers[get_class($command)] = $handler;
    }

    public function dispatch(CommandInterface $command): mixed
    {
        $commandClass = get_class($command);
        if (!isset($this->handlers[$commandClass])) {
            throw new \Exception("No handler registered for command: " . $commandClass);
        }

        return $this->handlers[$commandClass]->handle($command);
    }
}
