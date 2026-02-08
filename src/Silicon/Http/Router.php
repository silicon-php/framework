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

    public function match(Request $request): Route
    {
        foreach ($this->routes as [$method, $path, $controller, $middlewares]) {
            if (
                $method === $request->getMethod() &&
                $path === $request->getUri()
            ) {
                return new Route(
                    $controller,
                    $middlewares
                );
            }
        }
        throw new \RuntimeException('Route not found');
    }
}
