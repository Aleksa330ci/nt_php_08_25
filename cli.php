<?php
declare(strict_types=1);

define('BASE_DIR', __DIR__);

$envFile = BASE_DIR . '/.env';
if (is_file($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (strpos(ltrim($line), '#') === 0) continue;
        if (!strpos($line, '=')) continue;
        [$k, $v] = array_map('trim', explode('=', $line, 2));
        if ($k !== '') { putenv("$k=$v"); }
    }
}

require_once BASE_DIR . '/src/Core/helpers.php';
require_once BASE_DIR . '/src/Core/DB.php';

require_once BASE_DIR . '/src/Console/Contracts/Command.php';
require_once BASE_DIR . '/src/Console/Kernel.php';
require_once BASE_DIR . '/src/Console/Commands/_MigrationsBase.php';
require_once BASE_DIR . '/src/Console/Commands/MigrateCreate.php';
require_once BASE_DIR . '/src/Console/Commands/MigrateRun.php';
require_once BASE_DIR . '/src/Console/Commands/MigrateRollback.php';

use Console\Kernel;

try {
    $kernel = new Kernel();
    exit($kernel->run($argv));
} catch (Throwable $e) {
    fwrite(STDERR, "[CLI ERROR] ".$e->getMessage().PHP_EOL);
    exit(1);
}
