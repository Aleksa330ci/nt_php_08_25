<?php
declare(strict_types=1);

define('BASE_DIR', __DIR__);

require_once __DIR__ . '/src/Console/Contracts/Command.php';
require_once __DIR__ . '/src/Console/Kernel.php';
require_once __DIR__ . '/src/Console/Commands/MigrateCreate.php';
require_once __DIR__ . '/src/Console/Commands/MigrateRun.php';
require_once __DIR__ . '/src/Console/Commands/MigrateRollback.php';

use Console\Kernel;

try {
    $kernel = new Kernel();
    exit($kernel->run($argv));
} catch (Throwable $e) {
    fwrite(STDERR, "[CLI ERROR] " . $e->getMessage() . PHP_EOL);
    exit(1);
}
