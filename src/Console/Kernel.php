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
        // Реєстрація команд
        $this->commands = [
            'migration:create'   => new MigrateCreate(),
            'migration:run'      => new MigrateRun(),
            'migration:rollback' => new MigrateRollback(),
        ];
    }


    public function run(array $argv): int
    {
        if (count($argv) < 2) {
            $this->printHelp();
            return 0;
        }

        $commandName = $argv[1];
        $args = array_slice($argv, 2);

        if (!isset($this->commands[$commandName])) {
            fwrite(STDERR, "Unknown command: {$commandName}" . PHP_EOL);
            $this->printHelp();
            return 1;
        }

        $cmd = $this->commands[$commandName];

        return $cmd->handle($args);
    }

    private function printHelp(): void
    {
        echo "CLI helper\n";
        echo "Usage: php cli.php <command> [args]\n\n";
        echo "Available commands:\n";
        foreach ($this->commands as $name => $cmd) {
            echo "  - {$name}\n";
            echo "      " . $cmd->description() . "\n";
            echo "      " . $cmd->signature()   . "\n";
        }
        echo PHP_EOL;
        echo "Examples:\n";
        echo "  php cli.php migration:create create_products_table\n";
        echo "  php cli.php migration:run\n";
        echo "  php cli.php migration:rollback\n";
    }
}
