<?php
namespace Repositories;

use Core\DB;
use PDO;

class IngredientRepository
{
    private PDO $pdo;
    public function __construct() { $this->pdo = DB::connect(); }


}
