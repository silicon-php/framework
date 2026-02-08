<?php

namespace Silicon\Http;

final class CookieBag
{
    private array $cookies = [];
    private array $resolved = [];

    public function __construct(array $cookies = [])
    {
        $this->cookies = $cookies;
    }

    public function raw(string $name): ?string
    {
        return $this->cookies[$name] ?? '';
    }

    public function setResolved(string $name, mixed $value): void
    {
        $this->resolved[$name] = $value;
    }

    public function get(string $name): mixed
    {
        return $this->resolved[$name] ?? null;
    }
}
