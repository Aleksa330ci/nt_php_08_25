<?php
declare(strict_types=1);

use Core\{Request, Response, Router};

require_once __DIR__ . '/../src/Core/Autoload.php';

$req = Request::fromGlobals();
$router = new Router();

/** Підключаємо таблицю маршрутів */
(require __DIR__ . '/../routes/web.php')($router);

/** Виконуємо */
try {
    $result = $router->dispatch($req);
    // Якщо контролер повернув Response — віддати як є
    if ($result instanceof Response) {
        $result->send();
    } else {
        // Інакше загорнемо у JSON 200
        Response::json($result, 200)->send();
    }
} catch (Throwable $e) {
    // У проді логувати; тут — JSON 500
    Response::json([
        'error' => 'Internal Server Error',
        'message' => $e->getMessage(),
    ], 500)->send();
}
