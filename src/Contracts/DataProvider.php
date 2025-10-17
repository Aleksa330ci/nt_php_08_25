<?php
declare(strict_types=1);

namespace App\Contracts;

interface DataProvider
{
    public function getData(): string;
}
