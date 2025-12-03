<?php
namespace Services;

use Core\DB;
use PDO;

final class InventoryService
{
    public function canPrepareProduct(int $productId, int $qty, ?string &$reason = null): bool
    {
        $pdo = DB::connect();

      
        
        $sql = "
            SELECT r.ingredient_id, r.amount AS per_unit_needed, i.amount AS stock, i.name AS ingredient
            FROM recipes r
            JOIN ingredients i ON i.id = r.ingredient_id
            WHERE r.product_id = :pid
        ";
        $st = $pdo->prepare($sql);
        $st->execute([':pid' => $productId]);
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            $reason = 'Для продукту не задано рецепт (recipes).';
            return false; 
        }

        foreach ($rows as $row) {
            $need  = (float)$row['per_unit_needed'] * $qty;
            $stock = (float)$row['stock'];
            if ($stock < $need) {
                $reason = sprintf(
                    "Недостатньо інгредієнта '%s': потрібно %.2f, є %.2f",
                    $row['ingredient'], $need, $stock
                );
                return false;
            }
        }
        return true;
    }
}
