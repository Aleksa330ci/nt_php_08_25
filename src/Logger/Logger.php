<?php
declare(strict_types=1);

namespace App\Logger;

use App\Logger\Contracts\FormatStrategy;
use App\Logger\Contracts\DeliveryStrategy;

final class Logger
{
    public function __construct(
        private FormatStrategy $formatter,
        private DeliveryStrategy $delivery
    ) {}

    public function log(string $message): void
    {
        $this->delivery->deliver(
            $this->formatter->format($message)
        );
    }
}
