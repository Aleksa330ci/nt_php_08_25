<?php
declare(strict_types=1);

namespace App\Logger\Format;

use App\Logger\Contracts\FormatStrategy;

final class RawFormatter implements FormatStrategy
{
    public function format(string $message): string
    {
        return $message;
    }
}
