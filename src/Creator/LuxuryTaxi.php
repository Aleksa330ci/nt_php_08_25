<?php
declare(strict_types=1);

namespace App\Creator;

use App\Contracts\Car;
use App\Domain\Cars\LuxuryCar;

final class LuxuryTaxi extends TaxiService
{
    protected function createCar(): Car
    {
        return new LuxuryCar();
    }
}
