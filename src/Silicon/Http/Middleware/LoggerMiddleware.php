<?php

namespace Silicon\Http\Middleware;

use Silicon\Http\Request;
use Silicon\Http\Response;

class LoggerMiddleware implements MiddlewareInterface
{
    public function process(Request $request, Response $response, callable $next): Response
    {
        return $next($request, $response);
    }
}
