<?php
use Core\Router;
use Middleware\EnsureAuth;
use Middleware\EnsureRole;
use Controllers\Admin\OrdersController;

$auth = [EnsureAuth::class, 'handle'];
$adminOnly = [EnsureRole::class, 'handle'];

Router::get('/admin/orders',        [OrdersController::class, 'index'], middlewares: [[$auth], [$adminOnly, ['admin']]]);
Router::get('/admin/orders/show',   [OrdersController::class, 'show'],  middlewares: [[$auth], [$adminOnly, ['admin']]]);
Router::post('/admin/orders/delete',[OrdersController::class, 'destroy'],middlewares: [[$auth], [$adminOnly, ['admin']]]);
