<?php
declare(strict_types=1);

namespace App;

use App\Contracts\DataProvider;

final class Controller
{
    public function __construct(
        private DataProvider $adapter
    ) {}

    public function getData(): string
    {
        return $this->adapter->getData();
    }
}
