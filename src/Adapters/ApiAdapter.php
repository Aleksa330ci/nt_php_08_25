<?php
declare(strict_types=1);

namespace App\Adapters;

use App\Contracts\DataProvider;

final class ApiAdapter implements DataProvider
{
    public function getData(): string
    {
        
        return ' data from external API';
    }
}
