<?php

use Controllers\AuthController;
use Auth\Auth;

$router->get('/', function () {
    if (!Auth::check()) {
        header('Location: /login');
        return;
    }
    $user = Auth::user(\Core\DB::connect());
    require BASE_DIR . '/views/home/index.php';
});

// login (тільки для гостей)
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);

// logout
$router->get('/logout', [AuthController::class, 'logout']);
