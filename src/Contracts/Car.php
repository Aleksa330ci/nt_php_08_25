<?php
declare(strict_types=1);

namespace App\Contracts;

interface Car
{
    public function getModel(): string;
    public function getPrice(): int; 
}
