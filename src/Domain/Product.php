<?php
declare(strict_types=1);

namespace App\Domain;

final class Product
{
    public function __construct(
        private string $name,
        private float  $price,
        private ?string $sku = null,
    ) {}

    public function name(): string { /* ... */ }
    public function setName(string $name): void { /* ... */ }

    public function price(): float { /* ... */ }
    public function setPrice(float $price): void { /* ... */ }

    public function sku(): ?string { /* ... */ }
    public function setSku(?string $sku): void { /* ... */ }
}
