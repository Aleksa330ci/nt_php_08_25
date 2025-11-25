<?php
namespace Repositories;

use PDO;
use Core\DB;
use Throwable;

final class ProductRepository
{
    private PDO $pdo;
    private string $uploadDir;

    public function __construct()
    {
        $this->pdo = DB::connect();
        $this->uploadDir = BASE_DIR . '/public/uploads/products';
        if (!is_dir($this->uploadDir)) { @mkdir($this->uploadDir, recursive: true); }
    }

    public function all(): array
    {
        return $this->pdo->query('SELECT id,name,price,discount,thumbnail FROM products ORDER BY id DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $st = $this->pdo->prepare('SELECT * FROM products WHERE id=:id');
        $st->execute([':id'=>$id]);
        $r = $st->fetch();
        return $r ?: null;
    }

    private function storeImage(?array $image): ?string
    {
        if (!$image || $image['error'] !== UPLOAD_ERR_OK) return null;
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION) ?: 'jpg';
        $name = uniqid('p_', true) . '.' . strtolower($ext);
        $dest = $this->uploadDir . '/' . $name;
        if (!move_uploaded_file($image['tmp_name'], $dest)) {
            throw new \RuntimeException('Failed to save thumbnail');
        }
        return $name;
    }

    public function create(array $data, ?array $image): int
    {
        try {
            $this->pdo->beginTransaction();

            $thumb = $this->storeImage($image);

            $st = $this->pdo->prepare('
                INSERT INTO products (name,description,price,discount,thumbnail)
                VALUES (:n,:d,:p,:disc,:t)
            ');
            $st->execute([
                ':n'=>$data['name'],
                ':d'=>$data['description'],
                ':p'=>$data['price'],
                ':disc'=>$data['discount'],
                ':t'=>$thumb
            ]);

            $id = (int)$this->pdo->lastInsertId();


            $this->pdo->commit();
            return $id;
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            throw $e;
        }
    }

    public function update(int $id, array $data, ?array $image): void
    {
        try {
            $this->pdo->beginTransaction();

            $thumb = $this->storeImage($image);

            $sql = 'UPDATE products SET name=:n, description=:d, price=:p, discount=:disc';
            if ($thumb) $sql .= ', thumbnail=:t';
            $sql .= ' WHERE id=:id';

            $params = [
                ':n'=>$data['name'], ':d'=>$data['description'],
                ':p'=>$data['price'], ':disc'=>$data['discount'], ':id'=>$id
            ];
            if ($thumb) $params[':t'] = $thumb;

            $st = $this->pdo->prepare($sql);
            $st->execute($params);

            $this->pdo->commit();
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            throw $e;
        }
    }

    public function delete(int $id): void
    {
        $st = $this->pdo->prepare('DELETE FROM products WHERE id=:id');
        $st->execute([':id'=>$id]);
    }
}
