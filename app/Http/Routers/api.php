<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatusController;

use Silicon\Http\Router;

$router = new Router();

$router->add('GET', '/', HomeController::class, []);
$router->add('GET', '/status', StatusController::class, []);

/**
 * Authentication Routes
 */
$router->add('POST', '/login', LoginController::class, []);

return $router;
