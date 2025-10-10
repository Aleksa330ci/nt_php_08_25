<?php
declare(strict_types=1);

namespace App\Logger\Delivery;

use App\Logger\Contracts\DeliveryStrategy;

final class ConsoleDelivery implements DeliveryStrategy
{
    public function deliver(string $formatted): void
    {
        echo "Вивід формату ({$formatted}) в консоль";
    }
}
