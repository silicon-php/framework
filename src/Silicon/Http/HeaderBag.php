<?php

namespace Silicon\Http;

final class HeaderBag
{
    /** @var array<string, Header> */
    private array $headers = [];

    public function set(string $name, string|array $value): void
    {
        $this->headers[$this->normalize($name)] = new Header($name, $value);
    }

    public function add(string $name, string $value): void
    {
        $key = $this->normalize($name);

        if (!isset($this->headers[$key])) {
            $this->headers[$key] = new Header($name, $value);
            return;
        }

        $this->headers[$key]->add($value);
    }

    public function all(): array
    {
        return $this->headers;
    }

    private function normalize(string $name): string
    {
        return strtolower($name);
    }
}
