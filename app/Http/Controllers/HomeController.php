<?php

namespace App\Http\Controllers;

use Silicon\Http\Cookie;
use Silicon\Http\Request;
use Silicon\Http\Response;
use Silicon\Logger\LoggerInterface;

class HomeController
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(Request $req, Response $res): Response
    {
        return $res->json(['message' => 'OK'])
            ->setCookie(new Cookie('test', '9999'));
    }
}
