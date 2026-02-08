<?php

namespace Silicon\Http;

class Request
{
    public function __construct(
        public Parameter $query,
        public Parameter $body,
        public Parameter $headers,
        public CookieBag $cookies,
        public Parameter $server,
    ) {}

    public static function fromGlobals(): self
    {
        return new self(
            new Parameter($_GET),
            new Parameter($_POST),
            new Parameter(getallheaders()),
            new CookieBag($_COOKIE),
            new Parameter($_SERVER),
        );
    }

    public function cookies(): CookieBag
    {
        return $this->cookies;
    }

    public function getMethod(): string
    {
        return strtoupper($this->server->get('REQUEST_METHOD', 'GET'));
    }

    public function getUri(): string
    {
        return $this->server->get('REQUEST_URI', '/');
    }

    public function getContentType(): string
    {
        return $this->server->get('CONTENT_TYPE', '');
    }
}
