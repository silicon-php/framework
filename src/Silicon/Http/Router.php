<?php

namespace Silicon\Http;

use Silicon\Http\Request;
use Silicon\Http\Route;

class Router implements RouterInterface
{
    private array $routes = [];

    public function add(
        string $method,
        string $path,
        mixed $controller,
        array $middlewares = []
    ): void {
        $this->routes[] = [$method, $path, $controller, $middlewares];
    }

    private function matchPath(string $routePath, string $uri): ?array
    {
        $routeParts = explode('/', trim($routePath, '/'));
        $uriParts   = explode('/', trim($uri, '/'));

        if (count($routeParts) !== count($uriParts)) {
            return null;
        }
        $params = [];
        foreach ($routeParts as $i => $part) {
            if (str_starts_with($part, ':')) {
                $params[substr($part, 1)] = $uriParts[$i];
                continue;
            }
            if ($part !== $uriParts[$i]) {
                return null;
            }
        }
        return $params;
    }

    public function match(Request $request): Route
    {
        $uri = parse_url($request->getUri(), PHP_URL_PATH);

        foreach ($this->routes as [$method, $path, $controller, $middlewares]) {
            if ($method !== $request->getMethod()) {
                continue;
            }
            $params = $this->matchPath($path, $uri);
            if ($params !== null) {
                return new Route(
                    path: $path,
                    controller: $controller,
                    middlewares: $middlewares,
                    parameters: $params
                );
            }
        }
        throw new \RuntimeException('Route not found');
    }
}
