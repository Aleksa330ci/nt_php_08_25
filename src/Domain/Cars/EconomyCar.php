<?php
declare(strict_types=1);

namespace App\Domain\Cars;

use App\Contracts\Car;

final class EconomyCar implements Car
{
    public function getModel(): string
    {
        return 'Dacia Logan (Economy)';
    }

    public function getPrice(): int
    {
        return 120; // грн
    }
}
