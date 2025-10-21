<?php
declare(strict_types=1);

namespace App\Domain\Cars;

use App\Contracts\Car;

final class LuxuryCar implements Car
{
    public function getModel(): string
    {
        return 'Mercedes E-Class (Luxury)';
    }

    public function getPrice(): int
    {
        return 350;
    }
}
