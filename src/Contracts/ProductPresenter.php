<?php
declare(strict_types=1);

namespace App\Contracts;

use App\Domain\Product;

interface ProductPresenter
{
    public function show(Product $product): string;
    public function print(Product $product): string;
}
