<?php
use Core\Router;

return function (Router $router): void {
    // Простий GET
    $router->get('/test', [\App\Controllers\TestController::class, 'index']);

    // GET з id: /test/123
    $router->get('/test/{id}', [\App\Controllers\TestController::class, 'show']);

    // POST JSON: {"name":"Alexa"}
    $router->post('/test', [\App\Controllers\TestController::class, 'store']);

    // PUT /test/5
    $router->put('/test/{id}', [\App\Controllers\TestController::class, 'update']);

    // DELETE /test/5
    $router->delete('/test/{id}', [\App\Controllers\TestController::class, 'destroy']);
};
