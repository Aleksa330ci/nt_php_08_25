<?php
namespace Repositories;

use PDO;
use Core\DB;

final class UserRepository {
    private PDO $pdo;
    public function __construct() { $this->pdo = DB::connect(); }

    public function all(): array {
        return $this->pdo->query('SELECT id, name, email, role_id FROM users ORDER BY id DESC')->fetchAll();
    }

    public function find(int $id): ?array {
        $st = $this->pdo->prepare('SELECT id, name, email, role_id FROM users WHERE id = :id');
        $st->execute([':id'=>$id]);
        $r = $st->fetch(); return $r ?: null;
    }

    public function create(array $data): int {
        $st = $this->pdo->prepare('INSERT INTO users (name,email,password,role_id) VALUES (:n,:e,:p,:r)');
        $st->execute([
            ':n'=>$data['name'], ':e'=>$data['email'],
            ':p'=>$data['password'], ':r'=>$data['role_id'] ?? null
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): void {
        $sql = 'UPDATE users SET name=:n, email=:e, role_id=:r'
             . (isset($data['password']) && $data['password'] !== '' ? ', password=:p' : '')
             . ' WHERE id=:id';
        $st = $this->pdo->prepare($sql);
        $params = [':n'=>$data['name'], ':e'=>$data['email'], ':r'=>$data['role_id'] ?? null, ':id'=>$id];
        if (isset($data['password']) && $data['password'] !== '') $params[':p'] = $data['password'];
        $st->execute($params);
    }

    public function delete(int $id): void {
        $st = $this->pdo->prepare('DELETE FROM users WHERE id=:id');
        $st->execute([':id'=>$id]);
    }
}
