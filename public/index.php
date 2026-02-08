<?php

use Silicon\Factory\HttpApplication;

define('BASE_PATH', dirname(__DIR__));

require dirname(__DIR__) . '/vendor/autoload.php';
$apiRouter = require dirname(__DIR__) . '/app/Http/Routers/api.php';

$app = new HttpApplication();
$app->setRouter($apiRouter);
$app->run();
