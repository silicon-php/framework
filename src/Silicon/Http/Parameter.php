<?php

namespace Silicon\Http;

final class Parameter
{
    public function __construct(private array $parameters = []) {}

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->parameters[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->parameters;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->parameters);
    }
}
