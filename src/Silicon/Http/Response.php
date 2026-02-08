<?php

namespace Silicon\Http;

class Response
{
    protected HeaderBag $headers;

    /** @var array<Cookie> */
    private ?array $cookies = [];

    public function __construct(
        protected string $content = '',
        protected int $status = 200
    ) {
        $this->headers = new HeaderBag();
    }

    public function headers(): HeaderBag
    {
        return $this->headers;
    }

    public function setHeader(string $name, string|array $value): self
    {
        $this->headers->set($name, $value);
        return $this;
    }

    public function addHeader(string $name, string $value): self
    {
        $this->headers->add($name, $value);
        return $this;
    }

    public function setCookie(Cookie $cookie): self
    {
        $this->headers->add('Set-Cookie', (string) $cookie);
        return $this;
    }

    public function setSignedCookie(Cookie $cookie): self
    {
        $signed  = container()->get(SignedCookie::class);

        $this->setCookie($signed->create(
            $cookie->getName(),
            $cookie->getValue(),
            $cookie->getExpires(),
            $cookie->getPath(),
            $cookie->getDomain(),
            $cookie->isSecure(),
            $cookie->isHttpOnly(),
            $cookie->getSameSite()
        ));
        return $this;
    }

    public function setEncryptedCookie(Cookie $cookie): self
    {
        $encrypted  = container()->get(EncryptedCookie::class);

        $this->setCookie($encrypted->create(
            $cookie->getName(),
            $cookie->getValue(),
            $cookie->getExpires(),
            $cookie->getPath(),
            $cookie->getDomain(),
            $cookie->isSecure(),
            $cookie->isHttpOnly(),
            $cookie->getSameSite()
        ));
        return $this;
    }

    public function deleteCookie(string $name, string $path = '/', ?string $domain = null): self
    {
        return $this->setCookie(
            Cookie::delete($name, $path, $domain)
        );
    }

    public function body($content): self
    {
        $this->content = $content;
        return $this;
    }

    public function json(array $content): self
    {
        $this->headers()->set('Content-Type', 'application/json');
        $this->content = json_encode($content);
        return $this;
    }

    public function send(): void
    {
        http_response_code($this->status);
        foreach ($this->headers->all() as $header) {
            foreach ($header->toLines() as $line) {
                header($line, false);
            }
        }
        echo $this->content;
    }
}
