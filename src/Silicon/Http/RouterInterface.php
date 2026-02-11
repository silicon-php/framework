<?php

namespace Silicon\Http;

interface RouterInterface
{
    public function match(Request $request): mixed;
}
