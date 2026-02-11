<?php

namespace Silicon\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class ConsoleLogger implements LoggerInterface
{
    private $logger;

    public function __construct()
    {
        $this->logger = new Logger('app');
        $this->logger->pushHandler(new StreamHandler('php://stdout', Level::Debug));
    }

    public function log(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }

    public function error(string $message, \Exception $exception): void
    {
        $this->logger->error($message, [
            'exception' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
