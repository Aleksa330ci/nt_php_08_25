<?php
declare(strict_types=1);

namespace Console\Commands;

use Console\Contracts\Command;
use PDO;

final class MigrateRun extends _MigrationsBase implements Command
{
    public function description(): string
    {
        return 'Запустити всі ще не застосовані міграції (батчами).';
    }

    public function signature(): string
    {
        return 'migration:run';
    }

    public function handle(array $args): int
    {
        $this->ensureDir();
        $this->ensureMigrationsTable();

        db()->beginTransaction();
        try {
            $all = $this->listMigrations();           
            $done = $this->handledMigrations();    
            $pending = array_values(array_diff($all, $done['list']));

            if (empty($pending)) {
                echo "[info] Nothing to migrate\n";
                db()->commit();
                return 0;
            }

            $batch = $done['batch'] + 1;

            foreach ($pending as $file) {
                echo "[run] {$file}\n";
                $obj = $this->requireMigration($file);
                if (!$obj || !method_exists($obj, 'up')) {
                    echo "  -> skip (no up())\n";
                    continue;
                }
                $sql = (string)$obj->up();
                if ($sql !== '') {
                    $q = db()->prepare($sql);
                    $q->execute();
                }
                $this->insertRecord($file, $batch);
                echo "  -> migrated\n";
            }

            db()->commit();
            echo "[ok] Batch {$batch} done\n";
            return 0;
        } catch (\Throwable $e) {
            if (db()->inTransaction()) db()->rollBack();
            fwrite(STDERR, "[error] ".$e->getMessage()."\n");
            return 1;
        }
    }

    private function listMigrations(): array
    {
        $arr = is_dir($this->dir) ? scandir($this->dir) : [];
        $arr = array_values(array_diff($arr ?: [], ['.', '..']));
        sort($arr, SORT_STRING);
        return $arr;
    }

    private function handledMigrations(): array
    {
        $q = db()->query("SELECT migration, batch FROM migrations ORDER BY id ASC");
        $q->execute();
        $rows = $q->fetchAll(PDO::FETCH_ASSOC);

        $list = [];
        $batch = 0;
        foreach ($rows as $r) {
            $list[] = $r['migration'];
            $batch = (int)$r['batch'];
        }
        return ['list' => $list, 'batch' => $batch];
    }

    private function insertRecord(string $file, int $batch): void
    {
        $q = db()->prepare("INSERT INTO migrations (migration, batch) VALUES (:m, :b)");
        $q->bindValue(':m', $file);
        $q->bindValue(':b', $batch, PDO::PARAM_INT);
        $q->execute();
    }
}
