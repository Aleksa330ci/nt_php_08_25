<?php
declare(strict_types=1);

namespace Console\Commands;

use Console\Contracts\Command;

final class MigrateRollback implements Command
{
    public function description(): string
    {
        return 'Відкотити останній батч міграцій (плейсхолдер, без обовʼязкової реалізації).';
    }

    public function signature(): string
    {
        return 'migration:rollback';
    }

    public function handle(array $args): int
    {
        echo "[stub] Rolling back last batch...\n";
        echo "[stub] Done.\n";
        return 0;
    }
}
