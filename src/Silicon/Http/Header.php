<?php

namespace Silicon\Http;

final class Header
{
    private string $name;
    private array $values = [];

    public function __construct(string $name, string|array $values)
    {
        $this->name = self::normalizeName($name);
        $this->values = is_array($values) ? array_values($values) : [$values];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function set(string|array $values): void
    {
        $this->values = is_array($values) ? array_values($values) : [$values];
    }

    public function add(string $value): void
    {
        $this->values[] = $value;
    }

    public function hasValue(string $value): bool
    {
        return in_array($value, $this->values, true);
    }

    public function toString(): string
    {
        return $this->name . ': ' . implode(', ', $this->values);
    }

    public function toLines(): array
    {
        return array_map(
            fn($value) => $this->name . ': ' . $value,
            $this->values
        );
    }

    private static function normalizeName(string $name): string
    {
        return implode('-', array_map(
            'ucfirst',
            explode('-', strtolower($name))
        ));
    }
}
