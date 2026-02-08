<?php
return [
    'cookie' => [
        'secret' => 'test_a7b4e2d1a6c5b0e9d8f7a2c4e1b',
        'secure' => true,
        'same_site' => 'lax',
        'signed' => [''],
        'encrypted' => ['access_token', 'refresh_token'],
    ],
    'cors' => [
        'allowed_origins' => ['*'],
        'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
        'allowed_headers' => ['Content-Type', 'Authorization'],
        'exposed_headers' => [],
        'max_age' => 0,
        'supports_credentials' => true,
    ],
];
