<?php
use Core\Router;

return function (Router $router): void {
    $router->get('/test', [\App\Controllers\TestController::class, 'index']);

    $router->get('/test/{id}', [\App\Controllers\TestController::class, 'show']);

    $router->post('/test', [\App\Controllers\TestController::class, 'store']);

    $router->put('/test/{id}', [\App\Controllers\TestController::class, 'update']);

    $router->delete('/test/{id}', [\App\Controllers\TestController::class, 'destroy']);
};
