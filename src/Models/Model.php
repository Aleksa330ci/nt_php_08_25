<?php
declare(strict_types=1);

namespace Models;

use ORM\Queryable;

abstract class Model
{
    use Queryable;

    protected string $table;
    protected string $primaryKey = 'id';
}
