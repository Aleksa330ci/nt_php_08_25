<?php
const BASE_DIR = __DIR__ . '/..';
require BASE_DIR . '/vendor/autoload.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

\Dotenv\Dotenv::createUnsafeImmutable(BASE_DIR)->load();

require BASE_DIR . '/routes/web.php';
$router->dispatch(); // твій метод
