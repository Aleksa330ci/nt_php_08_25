<?php
declare(strict_types=1);

namespace Console\Commands;

use Console\Contracts\Command;

final class MigrateCreate implements Command
{
    private $migrationsDir;

    public function __construct()
    {
        $this->migrationsDir = BASE_DIR . '/database/migrations';
    }

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
        if (!isset($args[0]) || $args[0] === '') {
            fwrite(STDERR, "Missing required argument <name>\n");
            return 1;
        }

        if (!is_dir($this->migrationsDir)) {
            if (!mkdir($concurrentDirectory = $this->migrationsDir, 0777, true) && !is_dir($concurrentDirectory)) {
                fwrite(STDERR, "Unable to create migrations directory\n");
                return 1;
            }
            echo "[ok] Created directory: {$this->migrationsDir}\n";
        }

        $name = preg_replace('/[^a-z0-9_]+/i', '_', $args[0]);
        $filename = time() . '_' . $name . '.php';
        $path = $this->migrationsDir . '/' . $filename;

        $template = <<<PHP
<?php
 return new class {
    /** @return string SQL */
    public function up() {
        return '';
    }
    /** @return string SQL */
    public function down() {
        return '';
    }
};
PHP;

        if (file_put_contents($path, $template) === false) {
            fwrite(STDERR, "Failed to write file: {$path}\n");
            return 1;
        }

        echo "[ok] Migration created: {$path}\n";
        return 0;
    }
}
