<?php
declare(strict_types=1);

namespace Core;

use PDO;

class DB
{
    /** @var PDO|null */
    protected static $pdo = null;

    public static function connect(): PDO
    {
        if (static::$pdo instanceof PDO) {
            return static::$pdo;
        }

        $host    = getenv('DB_HOST') ?: 'localhost';
        $port    = getenv('DB_PORT') ?: '3306';
        $db      = getenv('DB_DATABASE') ?: 'test';
        $user    = getenv('DB_USER') ?: 'root';
        $pass    = getenv('DB_PASSWORD') ?: '';
        $charset = getenv('DB_CHARSET') ?: 'utf8mb4';

        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset={$charset}";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        static::$pdo = new PDO($dsn, $user, $pass, $opt);
        return static::$pdo;
    }
}
