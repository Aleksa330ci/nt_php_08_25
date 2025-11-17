<?php
namespace Core;
use PDO;

final class DB {
    private static ?PDO $pdo = null;

    public static function connect(): PDO {
        if (!self::$pdo) {
            $dsn = 'mysql:host='.(getenv('DB_HOST') ?: 'localhost').';dbname='.(getenv('DB_DATABASE') ?: 'coffee_db').';charset='. (getenv('DB_CHARSET') ?: 'utf8mb4');
            self::$pdo = new PDO($dsn, getenv('DB_USER') ?: 'root', getenv('DB_PASSWORD') ?: 'secret', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return self::$pdo;
    }
}
