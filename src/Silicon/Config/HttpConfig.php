<?php

namespace Silicon\Config;

class HttpConfig
{
    public CookieConfig $cookie;
    public CorsConfig $cors;

    public function __construct(array $config)
    {
        $this->cookie = new CookieConfig($config['cookie'] ?? []);
        $this->cors = new CorsConfig($config['cors'] ?? []);
    }
}
