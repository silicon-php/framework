<?php

namespace Silicon\Http;

final class Route
{
    public function __construct(
        public string $path,
        private mixed $controller,
        /* @var MiddlewareInterface[] */
        private array $middlewares = [],
        public array $parameters = []
    ) {
    }

    public function controller(): mixed
    {
        return $this->controller;
    }

    /* @return MiddlewareInterface[] */
    public function middlewares(): array
    {
        return $this->middlewares;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }
}
