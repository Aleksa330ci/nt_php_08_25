<?php
declare(strict_types=1);

use Core\{Request, Response, Router};

require_once __DIR__ . '/../src/Core/Autoload.php';

$req = Request::fromGlobals();
$router = new Router();

(require __DIR__ . '/../routes/web.php')($router);

try {
    $result = $router->dispatch($req);
    if ($result instanceof Response) {
        $result->send();
    } else {
        Response::json($result, 200)->send();
    }
} catch (Throwable $e) {
    Response::json([
        'error' => 'Internal Server Error',
        'message' => $e->getMessage(),
    ], 500)->send();
}
