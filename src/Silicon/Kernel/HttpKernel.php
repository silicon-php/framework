<?php

namespace Silicon\Kernel;

use Silicon\Http\ControllerResolver;
use Silicon\Http\Middleware\CookieMiddleware;
use Silicon\Http\Middleware\CorsMiddleware;
use Silicon\Http\Middleware\JsonMiddleware;
use Silicon\Http\Middleware\LoggerMiddleware;
use Silicon\Http\Middleware\MiddlewarePipeline;
use Silicon\Http\Request;
use Silicon\Http\Response;
use Silicon\Http\RouterInterface;

class HttpKernel implements KernelInterface
{
    private MiddlewarePipeline $pipeline;

    public function __construct(
        private RouterInterface $router
    ) {
        $this->pipeline = new MiddlewarePipeline(
            new ControllerResolver()
        );
    }

    public function handle(Request $request, Response $response): Response
    {
        $route = $this->router->match($request);
        $request->setRouteParams($route->parameters());
        $this->pipeline->setMiddlewares(array_merge($this->coreMiddlewares(), $route->middlewares()));
        return $this->pipeline->handle($request, $response, $route);
    }

    private function coreMiddlewares(): array
    {
        return [
            CorsMiddleware::class,
            CookieMiddleware::class,
            JsonMiddleware::class,
            LoggerMiddleware::class,
        ];
    }
}
