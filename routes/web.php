<?php
use Core\Router;
use Middleware\EnsureAuth;
use Middleware\EnsureGuest;
use Controllers\AuthController;

Router::get('/',              [EnsureAuth::class,  'handle'], fn() => view('home/index'));
Router::get('/login',         [EnsureGuest::class, 'handle'], [AuthController::class, 'showLogin']);
Router::post('/login',        [EnsureGuest::class, 'handle'], [AuthController::class, 'login']);
Router::post('/logout',       [EnsureAuth::class,  'handle'], [AuthController::class, 'logout']);
