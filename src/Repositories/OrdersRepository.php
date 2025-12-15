<?php
namespace Repositories;

use PDO;
use Core\DB;
use Throwable;

class OrdersRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    /* ==============================
     *   READ (для адмінки/баристи/юзера)
     * ============================== */

    /** Усі замовлення (адмінка) */
    public function all(): array
    {
        $sql = "
            SELECT o.*, u.name AS user_name
            FROM orders o
            LEFT JOIN users u ON u.id = o.user_id
            ORDER BY o.created_at DESC
        ";
        return $this->pdo->query($sql)->fetchAll();
    }

    /** Замовлення конкретного користувача (з пагінацією) */
    public function forUser(int $userId, int $page = 1, int $perPage = 20): array
    {
        $offset = max(0, ($page - 1) * $perPage);
        $st = $this->pdo->prepare("
            SELECT o.*, u.name AS user_name
            FROM orders o
            LEFT JOIN users u ON u.id = o.user_id
            WHERE o.user_id = :uid
            ORDER BY o.created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $st->bindValue(':uid', $userId, PDO::PARAM_INT);
        $st->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $st->bindValue(':offset', $offset, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll();
    }

    /** Сумісність із бариста-контролером */
    public function allForUser(int $userId): array
    {
        return $this->forUser($userId, 1, PHP_INT_MAX);
    }

    /** Замовлення + позиції */
    public function findWithItems(int $id): ?array
    {
        $head = $this->pdo->prepare("
            SELECT o.*, u.name AS user_name
            FROM orders o
            LEFT JOIN users u ON u.id = o.user_id
            WHERE o.id = :id
        ");
        $head->execute([':id' => $id]);
        $order = $head->fetch();
        if (!$order) return null;

        $items = $this->pdo->prepare("
            SELECT op.*, p.name AS product_name, p.thumbnail
            FROM order_products op
            JOIN products p ON p.id = op.product_id
            WHERE op.order_id = :id
            ORDER BY op.id ASC
        ");
        $items->execute([':id' => $id]);
        $order['items'] = $items->fetchAll();

        return $order;
    }

    /* ==============================
     *   CREATE
     * ============================== */

    /**
     * Створення замовлення (повертає ID)
     */
    public function create(
        int $userId,
        float $subtotal,
        float $discount,
        float $total,
        string $status = 'new'
    ): int {
        $st = $this->pdo->prepare("
            INSERT INTO orders (user_id, subtotal, discount, total, status, created_at, updated_at)
            VALUES (:uid, :subtotal, :discount, :total, :status, NOW(), NOW())
        ");
        $st->execute([
            ':uid'      => $userId,
            ':subtotal' => $subtotal,
            ':discount' => $discount,
            ':total'    => $total,
            ':status'   => $status,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Додає позиції до замовлення
     * $items: [
     *   product_id, qty, price, subtotal, name, thumbnail (name/thumbnail не обовʼязкові для БД)
     * ]
     */
    public function attachProducts(int $orderId, array $items): void
    {
        $st = $this->pdo->prepare("
            INSERT INTO order_products (order_id, product_id, qty, price, subtotal)
            VALUES (:oid, :pid, :qty, :price, :subtotal)
        ");

        foreach ($items as $row) {
            $st->execute([
                ':oid'     => $orderId,
                ':pid'     => (int)$row['product_id'],
                ':qty'     => (int)$row['qty'],
                ':price'   => (float)$row['price'],
                ':subtotal'=> (float)($row['subtotal'] ?? ($row['qty'] * $row['price'])),
            ]);
        }
    }

    /**
     * Віднімає кількості інгредієнтів згідно з рецептами (recipes)
     * recipes: product_id, ingredient_id, amount (скільки інгредієнта на 1 одиницю продукту)
     */
    public function decrementIngredients(array $items): void
    {
        // Збираємо потрібні кількості по кожному інгредієнту
        // SELECT ingredient_id, SUM(qty * amount) AS need FROM items x recipes GROUP BY ingredient_id
        $needByIngredient = [];

        $st = $this->pdo->prepare("
            SELECT ingredient_id, amount
            FROM recipes
            WHERE product_id = :pid
        ");

        foreach ($items as $row) {
            $pid = (int)$row['product_id'];
            $qty = (int)$row['qty'];

            $st->execute([':pid' => $pid]);
            foreach ($st->fetchAll() as $rec) {
                $ing  = (int)$rec['ingredient_id'];
                $need = (float)$rec['amount'] * $qty;
                $needByIngredient[$ing] = ($needByIngredient[$ing] ?? 0) + $need;
            }
        }

        if (empty($needByIngredient)) {
            return;
        }

        // Оновлюємо ingredients.amount = amount - need
        $upd = $this->pdo->prepare("
            UPDATE ingredients
            SET amount = amount - :need
            WHERE id = :id
        ");

        foreach ($needByIngredient as $ingId => $need) {
            $upd->execute([':need' => $need, ':id' => $ingId]);
        }
    }

    /* ==============================
     *   DELETE
     * ============================== */

    /** Видалення замовлення разом із позиціями (транзакція) */
    public function delete(int $id): bool
    {
        try {
            $this->pdo->beginTransaction();

            $st1 = $this->pdo->prepare("DELETE FROM order_products WHERE order_id = :id");
            $st1->execute([':id' => $id]);

            $st2 = $this->pdo->prepare("DELETE FROM orders WHERE id = :id");
            $st2->execute([':id' => $id]);

            $this->pdo->commit();
            return true;
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return false;
        }
    }
}
 