<?php

namespace Silicon\Http;

enum SameSite: string
{
    case LAX = 'Lax';
    case STRICT = 'Strict';
    case NONE = 'None';
}
