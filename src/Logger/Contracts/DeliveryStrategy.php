<?php
declare(strict_types=1);

namespace App\Logger\Contracts;

interface DeliveryStrategy
{
    public function deliver(string $formatted): void;
}
