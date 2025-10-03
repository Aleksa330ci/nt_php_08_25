<?php
declare(strict_types=1);

require_once __DIR__ . '/src/User.php';

try {
    $u = new User();

    $u->setName('Alexa');
    $u->setAge(25);

    $u->setEmail('alexa@example.com');

} catch (MethodNotAllowedException $e) {
    echo "⚠ {$e->getMessage()}", PHP_EOL;

} catch (Throwable $e) {
    echo "Помилка: {$e->getMessage()}", PHP_EOL;
}

if (isset($u)) {
    print_r($u->getData());
}
