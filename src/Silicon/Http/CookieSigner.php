<?php

namespace Silicon\Http;

final class CookieSigner
{
    private string $secret;
    private string $algo;
    public function __construct(
        string $secret,
        string $algo = 'sha256'
    ) {
        $this->secret = $secret;
        $this->algo = $algo;
    }
    public function sign(string $value): string
    {
        $signature = hash_hmac($this->algo, $value, $this->secret);
        return $value . '|' . $signature;
    }

    public function verify(string $signedValue): ?string
    {
        if (!str_contains($signedValue, '|')) {
            return null;
        }

        [$value, $signature] = explode('|', $signedValue, 2);

        $expected = hash_hmac($this->algo, $value, $this->secret);

        if (!hash_equals($expected, $signature)) {
            return null;
        }

        return $value;
    }
}
