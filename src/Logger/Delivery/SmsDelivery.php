<?php
declare(strict_types=1);

namespace App\Logger\Delivery;

use App\Logger\Contracts\DeliveryStrategy;

final class SmsDelivery implements DeliveryStrategy
{
    public function deliver(string $formatted): void
    {
        echo "Вивід формату ({$formatted}) в смс";
 
    }
}
