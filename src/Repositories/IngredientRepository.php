<?php
namespace Repositories;

use PDO;
use Core\DB;

final class IngredientRepository {
    private PDO $pdo;
    public function __construct() { $this->pdo = DB::connect(); }

    public function all(): array {
        return $this->pdo->query('SELECT id, name, amount FROM ingredients ORDER BY id DESC')->fetchAll();
    }

    public function find(int $id): ?array {
        $st = $this->pdo->prepare('SELECT id, name, amount FROM ingredients WHERE id=:id');
        $st->execute([':id'=>$id]);
        $r = $st->fetch(); return $r ?: null;
    }

    public function create(array $data): int {
        $st = $this->pdo->prepare('INSERT INTO ingredients (name, amount) VALUES (:n, :a)');
        $st->execute([':n'=>$data['name'], ':a'=>$data['amount'] ?? 0]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): void {
        $st = $this->pdo->prepare('UPDATE ingredients SET name=:n, amount=:a WHERE id=:id');
        $st->execute([':n'=>$data['name'], ':a'=>$data['amount'] ?? 0, ':id'=>$id]);
    }

    public function delete(int $id): void {
        $st = $this->pdo->prepare('DELETE FROM ingredients WHERE id=:id');
        $st->execute([':id'=>$id]);
    }
}
