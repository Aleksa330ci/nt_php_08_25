<?php
use Core\Router;
use Middleware\EnsureAuth;
use Controllers\Admin\ProductsController;

$mw = [EnsureAuth::class, 'handle'];

Router::get ('/admin/products',              $mw, [ProductsController::class, 'index']);
Router::get ('/admin/products/create',       $mw, [ProductsController::class, 'create']);
Router::post('/admin/products',              $mw, [ProductsController::class, 'store']);
Router::get ('/admin/products/{id}/edit',    $mw, [ProductsController::class, 'edit']);
Router::post('/admin/products/{id}/update',  $mw, [ProductsController::class, 'update']);
Router::post('/admin/products/{id}/delete',  $mw, [ProductsController::class, 'destroy']);
