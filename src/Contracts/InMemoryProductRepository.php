<?php
declare(strict_types=1);

namespace App\Infrastructure;

use App\Contracts\ProductRepository;
use App\Domain\Product;

final class InMemoryProductRepository implements ProductRepository
{
    /** @var array<int, Product> */
    private array $storage = [];

    public function getById(int $id): Product { /* ... */ }
    public function save(Product $product): int { /* ... */ }
    public function update(int $id, Product $product): void { /* ... */ }
    public function delete(int $id): void { /* ... */ }
}
