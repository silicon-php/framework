<?php

namespace Silicon\Http;

final class Route
{
    public function __construct(
        private mixed $controller,
        /* @var MiddlewareInterface[] */
        private array $middlewares = []
    ) {}

    public function controller(): mixed
    {
        return $this->controller;
    }

    /* @return MiddlewareInterface[] */
    public function middlewares(): array
    {
        return $this->middlewares;
    }
}
