<?php
declare(strict_types=1);

namespace Console\Commands;

use Console\Contracts\Command;

final class MigrateCreate extends _MigrationsBase implements Command
{
    public function description(): string
    {
        return 'Створити файл міграції у database/migrations/';
    }

    public function signature(): string
    {
        return 'migration:create <name>';
    }

    public function handle(array $args): int
    {
        $this->ensureDir();

        if (!isset($args[0]) || $args[0] === '') {
            fwrite(STDERR, "Missing required argument <name>\n");
            return 1;
        }

        $name = preg_replace('/[^a-z0-9_]+/i', '_', $args[0]);
        $file = time() . '_' . $name . '.php';
        $path = $this->dir . '/' . $file;

        $tpl = <<<'PHP'
<?php
return new class {
    public function up() {
        return ''; // SQL up
    }
    public function down() {
        return ''; // SQL down
    }
};
PHP;

        if (file_put_contents($path, $tpl) === false) {
            fwrite(STDERR, "Failed to write: {$path}\n");
            return 1;
        }

        echo "[ok] Migration created: {$file}\n";
        return 0;
    }
}
