<?php
use Core\Router;
use Middleware\EnsureAuth;
use Middleware\EnsureRole;
use Controllers\Barista\OrdersController;

$auth = [EnsureAuth::class, 'handle'];
$baristaOnly = [EnsureRole::class, 'handle'];

Router::get('/barista/orders',      [OrdersController::class, 'index'], middlewares: [[$auth], [$baristaOnly, ['barista']]]);
Router::get('/barista/orders/show', [OrdersController::class, 'show'],  middlewares: [[$auth], [$baristaOnly, ['barista']]]);
