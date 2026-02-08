<?php

namespace Silicon\Logger;

interface LoggerInterface
{
    public function log(string $message, array $context = []): void;
    public function info(string $message, array $context = []): void;
    public function warning(string $message, array $context = []): void;
    public function error(string $message, \Exception $exception): void;
}
