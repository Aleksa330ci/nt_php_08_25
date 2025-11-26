<?php

use Core\Router;
use Middleware\EnsureAuth;
use Controllers\Admin\ProductsController;

$middlewares = [
    [EnsureAuth::class, 'handle'],
];

Router::get ('/admin/products',             $middlewares, [ProductsController::class, 'index']);
Router::get ('/admin/products/create',      $middlewares, [ProductsController::class, 'create']);
Router::post('/admin/products',             $middlewares, [ProductsController::class, 'store']);
Router::get ('/admin/products/{id}/edit',   $middlewares, [ProductsController::class, 'edit']);
Router::post('/admin/products/{id}/update', $middlewares, [ProductsController::class, 'update']);
Router::post('/admin/products/{id}/delete', $middlewares, [ProductsController::class, 'destroy']);
