<?php
declare(strict_types=1);

namespace App\Contracts;

use App\Domain\Product;


interface ProductRepository
{
    public function getById(int $id): Product;      
    public function save(Product $product): int;    
    public function update(int $id, Product $product): void;
    public function delete(int $id): void;
}
