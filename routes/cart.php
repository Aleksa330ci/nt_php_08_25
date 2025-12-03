<?php

use Core\Router;
use Middleware\EnsureAuth; 
use Controllers\CartController;

$mw = [EnsureAuth::class, 'handle']; 
Router::get ('/cart',              $mw, [CartController::class, 'index']);
Router::post('/cart/add',          $mw, [CartController::class, 'add']);
Router::post('/cart/{id}/update',  $mw, [CartController::class, 'update']);  
Router::post('/cart/{id}/remove',  $mw, [CartController::class, 'remove']);
Router::post('/cart/clear',        $mw, [CartController::class, 'clear']);
