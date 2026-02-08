<?php

namespace Silicon\Http;

use DateTimeInterface;

final class SignedCookie
{
    public function __construct(
        private CookieSigner $signer
    ) {}

    public function create(
        string $name,
        string $value,
        int|DateTimeInterface|null $expires = 0,
        string $path = '/',
        ?string $domain = null,
        bool $secure = false,
        bool $httpOnly = true,
        ?string $sameSite = null
    ): Cookie {
        return new Cookie(
            $name,
            $this->signer->sign($value),
            $expires,
            $path,
            $domain,
            $secure,
            $httpOnly,
            $sameSite
        );
    }

    public function read(?string $rawValue): ?string
    {
        if ($rawValue === null) {
            return null;
        }

        return $this->signer->verify($rawValue);
    }
}
