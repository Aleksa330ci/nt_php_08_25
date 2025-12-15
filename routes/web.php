<?php
use Core\Router;
use Controllers\OrdersController;
use Middleware\EnsureAuth;

$mw = [EnsureAuth::class, 'handle'];

Router::get('/orders',            [OrdersController::class, 'index'],   $mw);
Router::get('/orders/show',       [OrdersController::class, 'show'],    $mw);
Router::post('/orders',           [OrdersController::class, 'store'],   $mw);
