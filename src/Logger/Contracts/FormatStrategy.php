<?php
declare(strict_types=1);

namespace App\Logger\Contracts;

interface FormatStrategy
{
    public function format(string $message): string;
}
