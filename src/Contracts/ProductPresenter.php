<?php
declare(strict_types=1);

namespace App\Contracts;

use App\Domain\Product;

/**
 * Контракт представлення продукту (HTML/CLI/JSON…)
 * SRP: окремо від домену і збереження.
 */
interface ProductPresenter
{
    public function show(Product $product): string;
    public function print(Product $product): string;
}
