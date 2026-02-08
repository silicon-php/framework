<?php

namespace Silicon\Http\Middleware;

use Silicon\Http\CookieSigner;
use Silicon\Http\CookieEncrypter;
use Silicon\Http\Request;
use Silicon\Http\Response;

final class CookieMiddleware implements MiddlewareInterface
{
    public function process(Request $request, Response $response, callable $next): Response
    {
        $signer = container()->get(CookieSigner::class);
        $encrypter = container()->get(CookieEncrypter::class);

        $cookies = $request->cookies();

        // 1️⃣ Signed cookies
        foreach ($this->signed() as $name) {
            $value = $signer->verify($cookies->raw($name));

            if ($value !== null) {
                $cookies->setResolved($name, $value);
            }
        }

        // 2️⃣ Encrypted cookies
        foreach ($this->encrypted() as $name) {
            $value = $encrypter->decrypt($cookies->raw($name));

            if ($value !== null) {
                $cookies->setResolved($name, $value);
            }
        }

        $response = $next($request, $response);

        return $response;
    }

    private function signed(): array
    {
        return config()->http()->cookie->signed;
    }

    private function encrypted(): array
    {
        return config()->http()->cookie->encrypted;
    }
}
