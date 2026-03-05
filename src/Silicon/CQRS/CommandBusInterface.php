<?php

namespace Silicon\CQRS;

interface CommandBusInterface
{
    public function register(CommandInterface $command, CommandHandlerInterface $handler): void;
    public function dispatch(CommandInterface $command): mixed;
}
