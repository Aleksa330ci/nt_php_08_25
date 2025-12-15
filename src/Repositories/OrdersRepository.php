<?php
namespace Repositories;

use PDO;
use Throwable;
use Core\DB;

final class OrdersRepository
{
    public function __construct(private PDO $pdo = new \PDO('sqlite::memory:')) 
    {
        $this->pdo = DB::connect();
    }

    /** @return int  */
    public function create(int $userId, float $subtotal, float $discount, float $total): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO orders (user_id, subtotal, discount, total)
            VALUES (:user_id, :subtotal, :discount, :total)
        ");
        $stmt->execute([
            ':user_id'  => $userId ?: null,
            ':subtotal' => $subtotal,
            ':discount' => $discount,
            ':total'    => $total,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function attachProducts(int $orderId, array $items): void
    {
        $sql = "
            INSERT INTO order_products (order_id, product_id, product_title, quantity, unit_price)
            VALUES (:order_id, :product_id, :product_title, :quantity, :unit_price)
        ";
        $stmt = $this->pdo->prepare($sql);

        foreach ($items as $it) {
            $stmt->execute([
                ':order_id'      => $orderId,
                ':product_id'    => $it['product_id'] ?? null,
                ':product_title' => $it['title'],
                ':quantity'      => (int)$it['qty'],
                ':unit_price'    => (float)$it['price'],
            ]);
        }
    }

    public function decrementIngredients(array $items): void { }

    public function forUser(int $userId, int $page = 1, int $perPage = 10): array
    {
        $offset = max(0, ($page - 1) * $perPage);
        $q = $this->pdo->prepare("
            SELECT * FROM orders
            WHERE user_id = :uid
            ORDER BY created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $q->bindValue(':uid', $userId, PDO::PARAM_INT);
        $q->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $q->bindValue(':offset', $offset, PDO::PARAM_INT);
        $q->execute();
        return $q->fetchAll();
    }

      public function findWithItems(int $orderId): ?array
    {
        $order = $this->pdo->prepare("SELECT * FROM orders WHERE id = :id LIMIT 1");
        $order->execute([':id' => $orderId]);
        $row = $order->fetch();
        if (!$row) return null;

        $items = $this->pdo->prepare("
            SELECT * FROM order_products WHERE order_id = :id ORDER BY id
        ");
        $items->execute([':id' => $orderId]);
        $row['items'] = $items->fetchAll();

        return $row;
    }
}
