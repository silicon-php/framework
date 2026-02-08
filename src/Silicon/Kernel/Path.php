<?php

namespace Silicon\Kernel;

final class Path
{
    public static function config(string $file = ''): string
    {
        return BASE_PATH . '/app/config' . ($file ? '/' . $file : '');
    }
}
