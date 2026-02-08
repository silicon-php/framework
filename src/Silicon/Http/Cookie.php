<?php

namespace Silicon\Http;

use DateTimeInterface;

final class Cookie
{
    private string $name;
    private string $value;
    private ?int $expires;
    private string $path;
    private ?string $domain;
    private bool $secure;
    private bool $httpOnly;
    private ?SameSite $sameSite;

    public function __construct(
        string $name,
        string $value = '',
        int|DateTimeInterface|null $expires = null,
        string $path = '/',
        ?string $domain = null,
        bool $secure = false,
        bool $httpOnly = true,
        ?SameSite $sameSite = null
    ) {
        if ($sameSite === SameSite::NONE && !$secure)
            throw new \InvalidArgumentException('Cookies with SameSite=None must be Secure');

        $this->name = $name;
        $this->value = $value;
        $this->expires = $expires instanceof DateTimeInterface
            ? $expires->getTimestamp()
            : $expires;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;
        $this->sameSite = $sameSite;
    }

    public static function delete(string $name, string $path = '/', ?string $domain = null): self
    {
        return new self(
            $name,
            '',
            time() - 3600,
            $path,
            $domain
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getExpires(): ?int
    {
        return $this->expires;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function isSecure(): bool
    {
        return $this->secure;
    }

    public function isHttpOnly(): bool
    {
        return $this->httpOnly;
    }

    public function getSameSite(): ?SameSite
    {
        return $this->sameSite;
    }

    public function __toString(): string
    {
        $parts = [rawurlencode($this->name) . '=' . rawurlencode($this->value)];

        if ($this->expires !== null) $parts[] = 'Expires=' . gmdate('D, d M Y H:i:s T', $this->expires);
        if ($this->path)  $parts[] = 'Path=' . $this->path;
        if ($this->domain) $parts[] = 'Domain=' . $this->domain;
        if ($this->secure)  $parts[] = 'Secure';
        if ($this->httpOnly) $parts[] = 'HttpOnly';
        if ($this->sameSite) $parts[] = 'SameSite=' . $this->sameSite->value;

        return implode('; ', $parts);
    }
}
