<?php

namespace Silicon\Http\Middleware;

use Silicon\Http\Request;
use Silicon\Http\Response;

class JsonMiddleware implements MiddlewareInterface
{
    public function process(Request $request, Response $response, callable $next): Response
    {
        if ($request->getContentType() === 'application/json') {
            $raw = file_get_contents('php://input');
            $jsonDecoded = json_decode($raw, true) ?? [];
            $request->body = new \Silicon\Http\Parameter($jsonDecoded);
        }
        return $next($request, $response);
    }
}
