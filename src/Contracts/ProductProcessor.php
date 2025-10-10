<?php
declare(strict_types=1);

namespace App\Application;

use App\Contracts\ProductPresenter;
use App\Contracts\ProductRepository;
use App\Domain\Product;

final class ProductProcessor
{
    public function __construct(
        private ProductRepository $repo,
        private ProductPresenter  $presenter,
    ) {}

    public function create(Product $product): int
    {
        throw new \LogicException('Not implemented');
    }

    public function update(int $id, Product $product): void
    {
        throw new \LogicException('Not implemented');
    }

    public function delete(int $id): void
    {
        throw new \LogicException('Not implemented');
    }

    public function show(int $id): string
    {
        throw new \LogicException('Not implemented');
    }

    public function print(int $id): string
    {
        throw new \LogicException('Not implemented');
    }
}
