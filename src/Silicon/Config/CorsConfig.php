<?php

namespace Silicon\Config;

final class CorsConfig
{
    public readonly array $allowedOrigins;
    public readonly array $allowedMethods;
    public readonly array $allowedHeaders;
    public readonly array $exposedHeaders;
    public readonly int $maxAge;
    public readonly bool $supportsCredentials;

    public function __construct(array $config)
    {
        $this->allowedOrigins = $config['allowed_origins'] ?? [];
        $this->allowedMethods = $config['allowed_methods'] ?? [];
        $this->allowedHeaders = $config['allowed_headers'] ?? [];
        $this->exposedHeaders = $config['exposed_headers'] ?? [];
        $this->maxAge = $config['max_age'] ?? 0;
        $this->supportsCredentials = $config['supports_credentials'] ?? false;
    }
}
