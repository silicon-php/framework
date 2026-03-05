<?php

namespace Silicon\CQRS;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command): mixed;
}
