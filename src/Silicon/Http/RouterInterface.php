<?php

namespace Silicon\Http;

use Silicon\Http\Request;

interface RouterInterface
{
    public function match(Request $request): mixed;
}
