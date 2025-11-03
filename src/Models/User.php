<?php
declare(strict_types=1);

namespace Models;

final class User extends Model
{
    protected string $table = 'users';
    protected string $primaryKey = 'id';
}
