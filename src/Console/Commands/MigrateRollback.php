<?php
declare(strict_types=1);

namespace Console\Commands;

use Console\Contracts\Command;
use PDO;

final class MigrateRollback extends _MigrationsBase implements Command
{
    public function description(): string
    {
        return 'Відкатити останній батч міграцій (down).';
    }

    public function signature(): string
    {
        return 'migration:rollback';
    }

    public function handle(array $args): int
    {
        $this->ensureDir();
        $this->ensureMigrationsTable();

        db()->beginTransaction();
        try {
            $rows = $this->lastBatchRows();
            if (empty($rows)) {
                echo "[info] Nothing to rollback\n";
                db()->commit();
                return 0;
            }

            foreach ($rows as $row) {
                $file = $row['migration'];
                echo "[down] {$file}\n";
                $obj = $this->requireMigration($file);
                if (!$obj || !method_exists($obj, 'down')) {
                    echo "  -> skip (no down())\n";
                    continue;
                }
                $sql = (string)$obj->down();
                if ($sql !== '') {
                    $q = db()->prepare($sql);
                    $q->execute();
                }
            }

            $this->deleteBatch((int)$rows[0]['batch']);

            db()->commit();
            echo "[ok] Rollback done\n";
            return 0;
        } catch (\Throwable $e) {
            if (db()->inTransaction()) db()->rollBack();
            fwrite(STDERR, "[error] ".$e->getMessage()."\n");
            return 1;
        }
    }

    private function lastBatchRows(): array
    {
        $q = db()->query("SELECT MAX(batch) AS b FROM migrations");
        $q->execute();
        $b = (int)($q->fetch(PDO::FETCH_ASSOC)['b'] ?? 0);

        if ($b === 0) return [];

        $q2 = db()->prepare("SELECT migration, batch FROM migrations WHERE batch = :b ORDER BY id DESC");
        $q2->bindValue(':b', $b, PDO::PARAM_INT);
        $q2->execute();
        return $q2->fetchAll(PDO::FETCH_ASSOC);
    }

    private function deleteBatch(int $batch): void
    {
        $q = db()->prepare("DELETE FROM migrations WHERE batch = :b");
        $q->bindValue(':b', $batch, PDO::PARAM_INT);
        $q->execute();
    }
}
