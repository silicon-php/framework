<?php

namespace Silicon\Factory;

use Silicon\Http\Request;
use Silicon\Http\Response;
use Silicon\Kernel\HttpKernel;
use Silicon\Http\Router;


class HttpApplication implements ApplicationInterface
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    private function initialize(): void
    {
        config();
        container();
    }

    public function boot(): void
    {
        $this->initialize();
    }

    public function run(): void
    {
        try {
            $this->boot();
            $request = Request::fromGlobals();
            $response = new Response("", 200);

            $kernel = new HttpKernel($this->router);

            $response = $kernel->handle($request, $response);
            $response->send();
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }

    private function error(\Throwable $th): void
    {
        if (config()->app()->debug) {
            $whoops = new \Whoops\Run;
            $whoops->allowQuit(false);
            $whoops->writeToOutput(false);
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            echo $whoops->handleException($th);
        } else {
            $response = new Response("Internal Server Error", 500);
            $response->send();
        }
    }

    public function setRouter(Router $router): void
    {
        $this->router = $router;
    }

    public function addRoute(
        string $method,
        string $path,
        mixed $controller,
        array $middlewares = []
    ) {
        $this->router->add($method, $path, $controller, $middlewares);
    }
}
