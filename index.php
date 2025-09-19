<?php
declare(strict_types=1);

require_once __DIR__ . '/tasks/task1.php';
require_once __DIR__ . '/tasks/task2.php';
require_once __DIR__ . '/tasks/task3.php';
require_once __DIR__ . '/tasks/task4.php';

/* ---- нижче необов’язковий демо-блок для швидкої перевірки ---- */
if (php_sapi_name() !== 'cli') {
    header('Content-Type: text/plain; charset=utf-8');

    echo "Task1 parity(5): "  . parity(5) . PHP_EOL;         // odd
    echo "Task1 isEven(12): " . (isEven(12) ? 'true' : 'false') . PHP_EOL;

    echo "Task2 gradeLetter(88): " . (gradeLetter(88) ?? 'null') . PHP_EOL; // B
    echo "Task2 gradeLetter(101): " . (gradeLetter(101) ?? 'null') . PHP_EOL; // null

    echo "Task3 sumPositive([1,-3,10,5]): " . sumPositive([1,-3,10,5]) . PHP_EOL; // 16
    echo "Task3 sumPositive([-5,-2]): " . sumPositive([-5,-2]) . PHP_EOL;         // 0

    echo "Task4 passwordStrength('qwe'): "        . passwordStrength('qwe') . PHP_EOL;        // weak
    echo "Task4 passwordStrength('qwertyu'): "    . passwordStrength('qwertyu') . PHP_EOL;    // medium
    echo "Task4 passwordStrength('Qwerty12345'): ". passwordStrength('Qwerty12345') . PHP_EOL; // strong
}
