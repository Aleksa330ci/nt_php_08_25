<?php
declare(strict_types=1);

require __DIR__ . '/src/Contracts/DataProvider.php';
require __DIR__ . '/src/Adapters/MysqlAdapter.php';
require __DIR__ . '/src/Adapters/ApiAdapter.php';
require __DIR__ . '/src/Controller.php';

use App\Adapters\MysqlAdapter;
use App\Adapters\ApiAdapter;
use App\Controller;

// підкладаємо будь-яку реалізацію інтерфейсу
$controller = new Controller(new MysqlAdapter());
echo $controller->getData(), PHP_EOL;

$controller = new Controller(new ApiAdapter());
echo $controller->getData(), PHP_EOL;
