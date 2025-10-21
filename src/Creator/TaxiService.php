<?php
declare(strict_types=1);

namespace App\Creator;

use App\Contracts\Car;

abstract class TaxiService
{
    abstract protected function createCar(): Car;

    public function orderRide(): string
    {
        $car = $this->createCar();

        return sprintf(
            "Your car: %s | Price: %d грн",
            $car->getModel(),
            $car->getPrice()
        );
    }
}
