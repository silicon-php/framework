<?php

namespace Silicon\Http\Middleware;

use Silicon\Http\Request;
use Silicon\Http\Response;

interface MiddlewareInterface
{
    public function process(Request $request, Response $response, callable $next): Response;
}
