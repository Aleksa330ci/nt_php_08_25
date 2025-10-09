<?php
declare(strict_types=1);

namespace App\Contracts;

use App\Domain\Product;

/**
 * Контракт зберігання/отримання продуктів.
 * SRP: окремо від сутності й від виводу.
 */
interface ProductRepository
{
    public function getById(int $id): Product;     // throws NotFoundException
    public function save(Product $product): int;    // повертає id
    public function update(int $id, Product $product): void;
    public function delete(int $id): void;
}
