<?php
declare(strict_types=1);

namespace App\Presentation;

use App\Contracts\ProductPresenter;
use App\Domain\Product;

final class HtmlProductPresenter implements ProductPresenter
{
    public function show(Product $product): string { /* ... */ }
    public function print(Product $product): string { /* ... */ }
}
