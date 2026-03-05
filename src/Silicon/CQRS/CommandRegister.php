<?php

namespace Silicon\CQRS;

class CommandRegister
{
    public function __construct(
        protected readonly CommandInterface $command,
        protected readonly CommandHandlerInterface $handler
    ) {}
}
