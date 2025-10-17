<?php
declare(strict_types=1);

namespace App\Adapters;

use App\Contracts\DataProvider;

final class MysqlAdapter implements DataProvider
{
    public function getData(): string
    {
    
        return ' data from MySQL';
    }
}
