<?php
declare(strict_types=1);

namespace Console;

use Console\Contracts\Command;
use Console\Commands\MigrateCreate;
use Console\Commands\MigrateRun;
use Console\Commands\MigrateRollback;

final class Kernel
{
    /** @var array<string, Command> */
    private $commands = [];

    public function __construct()
    {
        $this->commands = [
            'migration:create'   => new MigrateCreate(),
            'migration:run'      => new MigrateRun(),
            'migration:rollback' => new MigrateRollback(),
        ];
    }

    public function run(array $argv): int
    {
        if (count($argv) < 2) {
            $this->help();
            return 0;
        }

        $name = $argv[1];
        $args = array_slice($argv, 2);

        if (!isset($this->commands[$name])) {
            fwrite(STDERR, "Unknown command: {$name}\n");
            $this->help();
            return 1;
        }

        return $this->commands[$name]->handle($args);
    }

    private function help(): void
    {
        echo "CLI helper\n";
        echo "Usage: php cli.php <command> [args]\n\n";
        echo "Available commands:\n";
        foreach ($this->commands as $name => $cmd) {
            echo "  - {$name}\n";
            echo "      ".$cmd->description()."\n";
            echo "      ".$cmd->signature()."\n";
        }
        echo "\nExamples:\n";
        echo "  php cli.php migration:create create_products_table\n";
        echo "  php cli.php migration:run\n";
        echo "  php cli.php migration:rollback\n";
    }
}
