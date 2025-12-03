<?php
namespace Repositories;

use Core\DB;
use PDO;

class ProductRepository
{
    private PDO $pdo;
    public function __construct() { $this->pdo = DB::connect(); }

    public function find(int $id): ?array
    {
        $st = $this->pdo->prepare('SELECT * FROM products WHERE id=:id');
        $st->execute([':id' => $id]);
        $r = $st->fetch();
        return $r ?: null;
    }
}
