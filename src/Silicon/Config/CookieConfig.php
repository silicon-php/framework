<?php

namespace Silicon\Config;

final class CookieConfig
{
    public readonly string $secret;
    public readonly bool $secure;
    public readonly string $sameSite;
    public readonly array $signed;
    public readonly array $encrypted;

    public function __construct(array $config)
    {
        $this->secret = $config['secret'] ?? 'default_secret';
        $this->secure = $config['secure'] ?? false;
        $this->sameSite = $config['same_site'] ?? 'Lax';
        $this->signed = $config['signed'] ?? [];
        $this->encrypted = $config['encrypted'] ?? [];
    }
}
