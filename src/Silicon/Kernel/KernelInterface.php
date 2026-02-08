<?php

namespace Silicon\Kernel;

use Silicon\Http\Request;
use Silicon\Http\Response;

interface KernelInterface
{
    public function handle(Request $request, Response $response): Response;
}
