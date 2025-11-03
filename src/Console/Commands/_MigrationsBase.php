<?php
declare(strict_types=1);

namespace Console\Commands;

abstract class _MigrationsBase
{
    protected $dir;

    public function __construct()
    {
        $this->dir = BASE_DIR . '/database/migrations';
    }

    protected function ensureDir(): void
    {
        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0777, true);
            echo "[ok] Created directory: {$this->dir}\n";
        }
    }

    /**
     * @return object|null анонімний клас із методами up()/down()
     */
    protected function requireMigration(string $fileName)
    {
        $path = $this->dir . '/' . $fileName;
        if (!is_file($path)) {
            return null;
        }
        /** @noinspection PhpIncludeInspection */
        return require $path;
    }

    protected function ensureMigrationsTable(): void
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS migrations (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL UNIQUE,
            batch SMALLINT UNSIGNED NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        db()->exec($sql);
    }
}
