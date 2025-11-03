<?php
declare(strict_types=1);

namespace Console\Commands;

use Console\Contracts\Command;

final class MigrateRun implements Command
{
    public function description(): string
    {
        return 'Запустити міграції (плейсхолдер, без обовʼязкової реалізації).';
    }

    public function signature(): string
    {
        return 'migration:run';
    }

    public function handle(array $args): int
    {
        echo "[stub] Running migrations...\n";
        echo "[stub] Done.\n";
        return 0;
    }
}
