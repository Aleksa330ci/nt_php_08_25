<?php
declare(strict_types=1);

namespace App\Domain\Cars;

use App\Contracts\Car;

final class StandardCar implements Car
{
    public function getModel(): string
    {
        return 'Toyota Corolla (Standard)';
    }

    public function getPrice(): int
    {
        return 180;
    }
}
