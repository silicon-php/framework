<?php

namespace Silicon\Http\Middleware;

use Silicon\Http\Request;
use Silicon\Http\Response;

final class CorsMiddleware implements MiddlewareInterface
{
    private $config;
    public function process(Request $request, Response $response, callable $next): Response
    {
        $this->config = config()->http();
        if ($request->getMethod() === 'OPTIONS') {
            return $this->preflight($request);
        }

        $response = $next($request, $response);
        $this->applyHeaders($request, $response);

        return $response;
    }

    private function preflight(Request $request): Response
    {
        $response = new Response('', 204);
        return $this->applyHeaders($request, $response);
    }

    private function applyHeaders(Request $request, Response $response): Response
    {
        $origin = $request->headers->get('Origin');

        if ($origin && $this->isAllowedOrigin($origin)) {
            $response->headers()->set('Access-Control-Allow-Origin', $origin);
        }

        $response->headers()->set(
            'Access-Control-Allow-Methods',
            implode(', ', $this->config->cors->allowedMethods)
        );

        $response->headers()->set(
            'Access-Control-Allow-Headers',
            implode(', ', $this->config->cors->allowedHeaders)
        );

        if ($this->config->cors->supportsCredentials) {
            $response->headers()->set('Access-Control-Allow-Credentials', 'true');
        }

        if ($this->config->cors->maxAge > 0) {
            $response->headers()->set('Access-Control-Max-Age', (string) $this->config->cors->maxAge);
        }

        return $response;
    }

    private function isAllowedOrigin(string $origin): bool
    {
        return in_array($origin, $this->config->cors->allowedOrigins, true);
    }
}
