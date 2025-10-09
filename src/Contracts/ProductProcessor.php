<?php
declare(strict_types=1);

namespace App\Application;

use App\Contracts\ProductPresenter;
use App\Contracts\ProductRepository;
use App\Domain\Product;

/**
 * Application/Use-case рівень: orchestration.
 * Тут ми «обробляємо» продукт: збереження, оновлення, видалення, показ.
 */
final class ProductProcessor
{
    public function __construct(
        private ProductRepository $repo,
        private ProductPresenter  $presenter,
    ) {}

    public function create(Product $product): int
    {
        // валідація/бізнес-правила/події...
        // return $this->repo->save($product);
        /* ... */
    }

    public function update(int $id, Product $product): void
    {
        // $this->repo->update($id, $product);
        /* ... */
    }

    public function delete(int $id): void
    {
        // $this->repo->delete($id);
        /* ... */
    }

    public function show(int $id): string
    {
        // $product = $this->repo->getById($id);
        // return $this->presenter->show($product);
        /* ... */
    }

    public function print(int $id): string
    {
        // $product = $this->repo->getById($id);
        // return $this->presenter->print($product);
        /* ... */
    }
}
