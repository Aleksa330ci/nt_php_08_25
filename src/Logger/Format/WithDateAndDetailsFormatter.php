<?php
declare(strict_types=1);

namespace App\Logger\Format;

use App\Logger\Contracts\FormatStrategy;

final class WithDateAndDetailsFormatter implements FormatStrategy
{
    public function format(string $message): string
    {
        return date('Y-m-d H:i:s') . ' ' . $message . ' - With some details';
    }
}
